<?php
/* SVN FILE: $Id: class.Login.php 71 2008-08-02 19:03:43Z leveillej $ */
/**
*
* SimpleMC - BlueAtlas content manager
* Copyright 2008 - Present,
*      19508 Amaranth Dr., Suite D, Germantown, Maryland 20874 | 301.540.5950
*
* Redistributions of files must retain the above notice.
*
* @filesource
* @copyright      Copyright 2008 - Present, Blue Atlas Interactive
* @version        $Rev: 71 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-02 15:03:43 -0400 (Sat, 02 Aug 2008) $
*/

class Login
{
    private $_db;
    
    /***
    DESCRIPTION: validates a username and password for login
    PRE:   string alphanum username and password
    POST:   Query data is returned with 0 or more records
    ***/
    public function validate($username, $password)
    {
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        $data = array();
        
        if(ctype_alnum($username)) {
            $clean['username'] = $username;
        } else {
            return false;    
        }
        
        $clean['password'] = sha1($password);
        
        $mysql['username'] = $this->_db->real_escape_string($clean['username']);
        $mysql['password'] = $this->_db->real_escape_string($clean['password']);
        
        $sql=sprintf("SELECT u.username, r.role FROM `%susers` u INNER JOIN `%sroles` r ON  u.role_id = r.id WHERE username = '%s' AND password = '%s' LIMIT 1", Database::getTablePrefix(), Database::getTablePrefix(), $mysql['username'], $mysql['password']);
        $query = $this->_db->query($sql);
        $data = $query->fetch_assoc();
        
        $query->close();
        $this->_db->close();
        
        return $data;
    }   
    
    /***
    DESCRIPTION: logout
    POST: Terminates session
    ***/
    public function logout()
    {
        $_SESSION = array();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        
        session_destroy();
    }
}