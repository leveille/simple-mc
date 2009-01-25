<?php
/**
 * Class Minify  
 * @package Minify
 */

/**
 * Minify_Source
 */
require_once 'Minify/Source.php';
 
/**
 * Minify - Combines, minifies, and caches JavaScript and CSS files on demand.
 *
 * See README for usage instructions (for now).
 *
 * This library was inspired by {@link mailto:flashkot@mail.ru jscsscomp by Maxim Martynyuk}
 * and by the article {@link http://www.hunlock.com/blogs/Supercharged_Javascript "Supercharged JavaScript" by Patrick Hunlock}.
 *
 * Requires PHP 5.1.0.
 * Tested on PHP 5.1.6.
 *
 * @package Minify
 * @author Ryan Grove <ryan@wonko.com>
 * @author Stephen Clay <steve@mrclay.org>
 * @copyright 2008 Ryan Grove, Stephen Clay. All rights reserved.
 * @license http://opensource.org/licenses/bsd-license.php  New BSD License
 * @link http://code.google.com/p/minify/
 */
class Minify {

    const TYPE_CSS = 'text/css';
    const TYPE_HTML = 'text/html';
    // there is some debate over the ideal JS Content-Type, but this is the
    // Apache default and what Yahoo! uses..
    const TYPE_JS = 'application/x-javascript';
    
    /**
     * @see setCache()
     * @param mixed $cache object with identical interface as Minify_Cache_File or
     * a directory path. (default = '')
     * @return null
     * @deprecated
     */
    public static function useServerCache($path = null) 
    {
        self::setCache($path);
    }
    
    /**
     * Specify a cache object (with identical interface as Minify_Cache_File) or
     * a path to use with Minify_Cache_File.
     * 
     * If not called, Minify will not use a cache and, for each 200 response, will 
     * need to recombine files, minify and encode the output.
     *
     * @param mixed $cache object with identical interface as Minify_Cache_File or
     * a directory path. (default = '')
     *
     * @return null
     */
    public static function setCache($cache = '')
    {
        if (is_string($cache)) {
            require_once 'Minify/Cache/File.php';
            self::$_cache = new Minify_Cache_File($cache);
        } else {
            self::$_cache = $cache;
        }
    }
    
    private static $_cache = null;

    /**
     * Serve a request for a minified file. 
     * 
     * Here are the available options and defaults in the base controller:
     * 
     * 'isPublic' : send "public" instead of "private" in Cache-Control 
     * headers, allowing shared caches to cache the output. (default true)
     * 
     * 'quiet' : set to true to have serve() return an array rather than sending
     * any headers/output (default false)
     * 
     * 'encodeOutput' : to disable content encoding, set this to false (default true)
     * 
     * 'encodeMethod' : generally you should let this be determined by 
     * HTTP_Encoder (leave null), but you can force a particular encoding
     * to be returned, by setting this to 'gzip', 'deflate', or '' (no encoding)
     * 
     * 'encodeLevel' : level of encoding compression (0 to 9, default 9)
     * 
     * 'contentTypeCharset' : appended to the Content-Type header sent. Set to a falsey
     * value to remove. (default 'UTF-8')  
     * 
     * 'setExpires' : set this to a timestamp to have Minify send an HTTP Expires
     * header instead of checking for conditional GET (default null). 
     * E.g. ($_SERVER['REQUEST_TIME'] + 86400 * 365) for 1yr 
     * Note this has nothing to do with server-side caching.
     * 
     * 'minifiers' : to override Minify's default choice of minifier function for 
     * a particular content-type, specify your callback under the key of the 
     * content-type:
     * <code>
     * // call customCssMinifier($css) for all CSS minification
     * $options['minifiers'][Minify::TYPE_CSS] = 'customCssMinifier';
     * 
     * // don't minify Javascript at all
     * $options['minifiers'][Minify::TYPE_JS] = '';
     * </code>
     * 
     * 'minifierOptions' : to send options to the minifier function, specify your options
     * under the key of the content-type. E.g. To send the CSS minifier an option: 
     * <code>
     * // give CSS minifier array('optionName' => 'optionValue') as 2nd argument 
     * $options['minifierOptions'][Minify::TYPE_CSS]['optionName'] = 'optionValue';
     * </code>
     * 
     * Any controller options are documented in that controller's setupSources() method.
     * 
     * @param mixed instance of subclass of Minify_Controller_Base or string name of
     * controller. E.g. 'Files'
     * 
     * @param array $options controller/serve options
     * 
     * @return mixed null, or, if the 'quiet' option is set to true, an array
     * with keys "success" (bool), "statusCode" (int), "content" (string), and
     * "headers" (array).
     */
    public static function serve($controller, $options = array()) {
        if (is_string($controller)) {
            // make $controller into object
            $class = 'Minify_Controller_' . $controller;
            if (! class_exists($class, false)) {
                require_once "Minify/Controller/{$controller}.php";    
            }
            $controller = new $class();
        }
        
        // set up controller sources and mix remaining options with
        // controller defaults
        $options = $controller->setupSources($options);
        $options = $controller->analyzeSources($options);
        self::$_options = $controller->mixInDefaultOptions($options);
        
        if (! $controller->sources) {
            // invalid request!
            if (! self::$_options['quiet']) {
                header(self::$_options['badRequestHeader']);
                echo self::$_options['badRequestHeader'];
                return;
            } else {
                list(,$statusCode) = explode(' ', self::$_options['badRequestHeader']);
                return array(
                    'success' => false
                    ,'statusCode' => (int)$statusCode
                    ,'content' => ''
                    ,'headers' => array()
                );
            }
        }
        
        self::$_controller = $controller;

        if (null === self::$_options['setExpires']) {
            // conditional GET
            require_once 'HTTP/ConditionalGet.php';
            $cg = new HTTP_ConditionalGet(array(
                'lastModifiedTime' => self::$_options['lastModifiedTime']
                ,'isPublic' => self::$_options['isPublic']
            ));
            if ($cg->cacheIsValid) {
                // client's cache is valid
                if (! self::$_options['quiet']) {
                    $cg->sendHeaders();
                    return;
                } else {
                    return array(
                        'success' => true
                        ,'statusCode' => 304 
                        ,'content' => ''
                        ,'headers' => array()
                    );    
                }
            } else {
                // client will need output
                $headers = $cg->getHeaders();
                unset($cg);
            }
        } else {
            // don't need conditional GET
            $privacy = self::$_options['isPublic']
                ? 'public'
                : 'private';
            $headers = array(
                'Cache-Control' => $privacy . ', max-age=' 
                    . (self::$_options['setExpires'] - $_SERVER['REQUEST_TIME'])
                ,'Expires' => gmdate('D, d M Y H:i:s \G\M\T', self::$_options['setExpires'])
            );
        }
        
        // determine encoding
        if (self::$_options['encodeOutput']) {
            if (self::$_options['encodeMethod'] !== null) {
                // controller specifically requested this
                $contentEncoding = self::$_options['encodeMethod'];
            } else {
                // sniff request header
                require_once 'HTTP/Encoder.php';
                // depending on what the client accepts, $contentEncoding may be 
                // 'x-gzip' while our internal encodeMethod is 'gzip'. Calling
                // getAcceptedEncoding() with false leaves out compress as an option.
                list(self::$_options['encodeMethod'], $contentEncoding) = HTTP_Encoder::getAcceptedEncoding(false);
            }
        } else {
            self::$_options['encodeMethod'] = ''; // identity (no encoding)
        }
        
        if (null !== self::$_cache) {
            // using cache
            // the goal is to use only the cache methods to sniff the length and 
            // output the content, as they do not require ever loading the file into
            // memory.
            $cacheId = 'minify_' . self::_getCacheId();
            $encodingExtension = self::$_options['encodeMethod']
                ? ('deflate' === self::$_options['encodeMethod']
                    ? '.zd'
                    : '.zg')
                : '';
            $fullCacheId = $cacheId . $encodingExtension;
            // check cache for valid entry
            $cacheIsReady = self::$_cache->isValid($fullCacheId, self::$_options['lastModifiedTime']); 
            if ($cacheIsReady) {
                $cacheContentLength = self::$_cache->getSize($fullCacheId);    
            } else {
                // generate & cache content
                $content = self::_combineMinify();
                self::$_cache->store($cacheId, $content);
                self::$_cache->store($cacheId . '.zd', gzdeflate($content, self::$_options['encodeLevel']));
                self::$_cache->store($cacheId . '.zg', gzencode($content, self::$_options['encodeLevel']));
            }
        } else {
            // no cache
            $cacheIsReady = false;
            $content = self::_combineMinify();
        }
        if (! $cacheIsReady && self::$_options['encodeMethod']) {
            // still need to encode
            $content = ('deflate' === self::$_options['encodeMethod'])
                ? gzdeflate($content, self::$_options['encodeLevel'])
                : gzencode($content, self::$_options['encodeLevel']);
        }
        
        // add headers
        $headers['Content-Length'] = $cacheIsReady
            ? $cacheContentLength
            : strlen($content);
        $headers['Content-Type'] = self::$_options['contentTypeCharset']
            ? self::$_options['contentType'] . '; charset=' . self::$_options['contentTypeCharset']
            : self::$_options['contentType'];
        if (self::$_options['encodeMethod'] !== '') {
            $headers['Content-Encoding'] = $contentEncoding;
            $headers['Vary'] = 'Accept-Encoding';
        }

        if (! self::$_options['quiet']) {
            // output headers & content
            foreach ($headers as $name => $val) {
                header($name . ': ' . $val);
            }
            if ($cacheIsReady) {
                self::$_cache->display($fullCacheId);
            } else {
                echo $content;
            }
        } else {
            return array(
                'success' => true
                ,'statusCode' => 200
                ,'content' => $cacheIsReady
                    ? self::$_cache->fetch($fullCacheId)
                    : $content
                ,'headers' => $headers                
            );
        }
    }
    
    /**
     * @var Minify_Controller active controller for current request
     */
    protected static $_controller = null;
    
    /**
     * @var array options for current request
     */
    protected static $_options = null;
    
    /**
     * Combines sources and minifies the result.
     *
     * @return string
     */
    protected static function _combineMinify() {
        $type = self::$_options['contentType']; // ease readability
        
        // when combining scripts, make sure all statements separated
        $implodeSeparator = ($type === self::TYPE_JS)
            ? ';'
            : '';
        
        // allow the user to pass a particular array of options to each
        // minifier (designated by type). source objects may still override
        // these
        $defaultOptions = isset(self::$_options['minifierOptions'][$type])
            ? self::$_options['minifierOptions'][$type]
            : array();
        // if minifier not set, default is no minification. source objects
        // may still override this
        $defaultMinifier = isset(self::$_options['minifiers'][$type])
            ? self::$_options['minifiers'][$type]
            : false;
       
        if (Minify_Source::haveNoMinifyPrefs(self::$_controller->sources)) {
            // all source have same options/minifier, better performance
            // to combine, then minify once
            foreach (self::$_controller->sources as $source) {
                $pieces[] = $source->getContent();
            }
            $content = implode($implodeSeparator, $pieces);
            if ($defaultMinifier) {
                self::$_controller->loadMinifier($defaultMinifier);
                $content = call_user_func($defaultMinifier, $content, $defaultOptions);    
            }
        } else {
            // minify each source with its own options and minifier, then combine
            foreach (self::$_controller->sources as $source) {
                // allow the source to override our minifier and options
                $minifier = (null !== $source->minifier)
                    ? $source->minifier
                    : $defaultMinifier;
                $options = (null !== $source->minifyOptions)
                    ? array_merge($defaultOptions, $source->minifyOptions)
                    : $defaultOptions;
                if ($defaultMinifier) {
                    self::$_controller->loadMinifier($minifier);
                    // get source content and minify it
                    $pieces[] = call_user_func($minifier, $source->getContent(), $options);     
                } else {
                    $pieces[] = $source->getContent();     
                }
            }
            $content = implode($implodeSeparator, $pieces);
        }
        
        // do any post-processing (esp. for editing build URIs)
        if (self::$_options['postprocessorRequire']) {
            require_once self::$_options['postprocessorRequire'];
        }
        if (self::$_options['postprocessor']) {
            $content = call_user_func(self::$_options['postprocessor'], $content, $type);
        }
        return $content;
    }
    
    /**
     * Make a unique cache id for for this request.
     * 
     * Any settings that could affect output are taken into consideration  
     *
     * @return string
     */
    protected static function _getCacheId() {
        return md5(serialize(array(
            Minify_Source::getDigest(self::$_controller->sources)
            ,self::$_options['minifiers'] 
            ,self::$_options['minifierOptions']
        )));
    }    
}
