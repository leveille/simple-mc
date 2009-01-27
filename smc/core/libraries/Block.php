<?php

class Block extends Database
{
    private $_db;
    private $_sanitize;
    
    function __construct() 
    {
        $this->_sanitize = new Sanitize();
    }
    
    /***
    DESCRIPTION: Creates a content block
    @data (string), @desc (string)
    POST:	A content block is created
    ***/
    public function create($data, $desc)
    {
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
            $desc = stripslashes($desc);
        }
        
        $clean['data'] = $this->_sanitize->filter($data);
        $clean['description'] = $this->_sanitize->filter($desc);
        
        $mysql['data'] = $this->_db->real_escape_string($clean['data']);
        $mysql['description'] = $this->_db->real_escape_string($clean['description']);
        
        $sql=sprintf("INSERT INTO `%sblocks` (block, description) VALUES ('%s', '%s', %s)", Database::getTablePrefix(), $mysql['data'], $mysql['description']);
        $this->_db->query($sql);
        $lastInsertId = $this->_db->insert_id;
        $this->_db->close();
        
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cache->create($lastInsertId, $clean['data'], $clean['description']);
        }
    }
    
    /***
    DESCRIPTION: Grabs data for a content block and wraps it in a _wrapper
    @id (int)
    POST:	data is wrapped and returned in _wrapper
    ***/
    public function get($id = int)
    {
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cachedData = $cache->retrieve($id);
    
            if(!empty($cachedData)) {
                $cachedData = json_decode($cachedData, true);
                return Block::_wrapper($id, $cachedData['block'], $cachedData['description']);
            }
        }
        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        $clean['id'] = (int)$id;
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        
        $sql=sprintf("SELECT block, description FROM `%sblocks` WHERE id = %s", Database::getTablePrefix(), $mysql['id']);
        $query = $this->_db->query($sql);
        $content = '';
        
        if($query->num_rows > 0) {
            $data = $query->fetch_assoc();            
            $data['block'] = $this->_sanitize->filter($data['block']);
            $data['description'] = $this->_sanitize->filter($data['description']);
            
            $content = Block::_wrapper($id, $data['block'], $data['description']);
        } else {
            $content = "<p>Error: Content block <strong>${id}</strong> does not exist.  Please specify a valid content block.</p>";
        }
        
        $query->close();
        $this->_db->close();
        
        return $content;
    }
    
    /***
    DESCRIPTION: Grabs raw content block from the database for an id
    @id (int)
    ***/
    public function getUnwrapped($id = int)
    {
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cachedData = $cache->retrieve($id);
            
            if($cachedData) {
                $cachedData = json_decode($cachedData, true);
                return $cachedData['block'];
            }
        }
        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        $clean['id'] = (int)$id;
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        
        $sql=sprintf("SELECT block FROM `%sblocks` WHERE id = %s", Database::getTablePrefix(), $mysql['id']);
        $query = $this->_db->query($sql);
        
        if($query->num_rows > 0) {
            $data = $query->fetch_assoc();
        } else {
            $data['block'] = 'Error: This block does not exist.';
        }
        
        $query->close();
        $this->_db->close();
        
        return $this->_sanitize->filter($data['block']);
    }
    
    /***
    DESCRIPTION: grabs all content blocks
    POST: Returns the result set as encoded json
    ***/
    public function getContentBlocks()
    {     
        $this->_db = Database::connect();
        
        $arr = array();
        
        $sql = sprintf("SELECT id, description, block AS source, CONCAT('<?php echo $', 'block->get(', id, '); ?>') AS 'shortcut' FROM `%sblocks` ORDER BY id", Database::getTablePrefix());
        
        if($query = $this->_db->query($sql)) { 
            while ($obj = $query->fetch_object()) { 
                $arr[] = $obj;
            }
            
            /*
            * This can really slow things down for the administrator, therefore we'll disable it by default
            * In reality, data coming from the database should be filtered, however, we'll assume (albeit this is rarely a safe assumption)
            * that all content blocks have been filtered prior to getting stored in the database
            */ 
            foreach($arr as &$value) { 
                $value->id = (int)$value->id;
                //$value->description = $this->_sanitize->filter($value->description);
                $value->description = stripslashes($value->description);
                //$value->source = $this->_sanitize->filter($value->source);
                $value->source = stripslashes($value->source);
            }
            $query->close(); 
        } 
        
        $this->_db->close();
        return '{"results":' . json_encode($arr) . '}';
    }
    
    /***
    DESCRIPTION: updates content of a content block
    @id (int), @content (string), @description (string)
    POST:	content block is updated w/ new content
    ***/
    public function blockUpdate($id = int, $content, $description) 
    { 
        $this->_db = Database::connect();
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $content = stripslashes($content);
        }
        
        $clean['id'] = (int)$id;
        $clean['content'] = $this->_sanitize->filter($content);
        $clean['description'] = $this->_sanitize->stripTags($description);
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['content'] = $this->_db->real_escape_string($clean['content']);
        $mysql['description'] = $this->_db->real_escape_string($clean['description']);
        
        $sql=sprintf("UPDATE `%sblocks` SET block = '%s', description = '%s' WHERE id = %s",  Database::getTablePrefix(), $mysql['content'], $mysql['description'], $mysql['id']);;
        $this->_db->query($sql);
        $this->_db->close();
        
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cache->update($clean['id'], $clean['content'], $clean['description']);
        }
    }
    
    /***
    DESCRIPTION: updates content of a content block
    @id (int), @content (string), @description (string)
    POST: content block is updated w/ new content
    ***/
    public function blockUpdateAll($id = int, $content, $description) 
    { 
        $this->_db = Database::connect();
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $content = stripslashes($content);
            $description = stripslashes($description);
        }
        
        $clean['id'] = (int)$id;
        $clean['content'] = $this->_sanitize->filter($content);
        $clean['description'] = $this->_sanitize->filter($description);
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['content'] = $this->_db->real_escape_string($clean['content']);
        $mysql['description'] = $this->_db->real_escape_string($clean['description']);
        
        $sql=sprintf("UPDATE `%sblocks` SET block = '%s', description = '%s' WHERE id = %s", Database::getTablePrefix(), $mysql['content'], $mysql['description'], $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
        
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cache->update($clean['id'], $clean['content'], $clean['description']);
        }
    }
    
    /***
    DESCRIPTION: deletes a content block
    @id (int)
    POST: content block is removed
    ***/
    public function blockDelete($id = int) 
    { 
        $this->_db = Database::connect();
        $clean = array();
        $mysql = array();
        
        $clean['id'] = (int)$id;
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        
        $sql=sprintf("DELETE FROM `%sblocks` WHERE id = %s", Database::getTablePrefix(), $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
        
        $cache = new Cache();
        if(Cache::isEnabled()) {
            $cache->delete($clean['id']);
        }
    }
                
    /***
    DESCRIPTION: creates an editable wrapper for content blocks
    @id (int), @data (string), @description (string)
    POST:	Query data is returned with 0 or more records
    ***/ 
    private function _wrapper($id = int, $data, $description) 
    {
        if($this->_isAdmin() || $this->_isEditor()) {
            return sprintf('<div id="%s" class="editable" title="%s">%s</div>', $id, $description, $data);
        } else {
            return $data;
        }
    }
    
    /***
    DESCRIPTION: checks to see if user is admin
    POST:	Returns true or false
    ***/
    private function _isAdmin()
    {
        return (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true);
    }
    
    /***
    DESCRIPTION: checks to see if user is an editor
    POST:	Returns true or false
    ***/
    private function _isEditor()
    {
        return (isset($_SESSION['isEditor']) && $_SESSION['isEditor'] == true);
    }
}
