<?php
/**
 * SimpleMC - http://github.com/leveille/simple-mc/tree/master
 * Copyright (C) Blue Atlas Interactive
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 * == END LICENSE ==
 */
class Login
{
    private $_db;
    
    /**
     * tries to fetch a queryset based on username/password
     * @return queryset object
     * @param string $username
     * @param string $password
     */
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
    
    /**
     * logout
     */
    public function logout()
    {
        $_SESSION = array();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        
        session_destroy();
    }
}