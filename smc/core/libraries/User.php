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
class User
{
    private $_db;
    private $_sanitize;
    
    function __construct() 
    {
        $this->_sanitize = new Sanitize();
    }
    
    /***
    DESCRIPTION: Creates a new user
    PRE:	@username (string), @password (string - will be converted to SHA1 here), @role_id (int)
    POST:	A user is created
    ***/
    public function create($username, $password, $role_id = int)
    {			
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $username = stripslashes($username);
            $password = stripslashes($password);
        }
        
        $clean['username'] = $this->_sanitize->stripTagsEncode($username);
        $clean['password'] = $this->_sanitize->stripTagsEncode($password);
        $clean['role_id'] = (int)$role_id;
        
        $mysql['username'] = $this->_db->real_escape_string($clean['username']);
        $mysql['password'] = $this->_db->real_escape_string(sha1($clean['password']));
        $mysql['role_id'] = $this->_db->real_escape_string($clean['role_id']);
        
        $sql=sprintf("INSERT INTO `%susers` (username, password, role_id) VALUES ('%s', '%s', '%s')", Database::getTablePrefix(), $mysql['username'], $mysql['password'], $mysql['role_id']);
        $this->_db->query($sql);
        $this->_db->close();
    }
    
    /***
    DESCRIPTION: Checks to see if a username already exists in the database
    PRE:  @username (string)
    POST: Boolean result is returned
    ***/
    public function userExists($username)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $username = stripslashes($username);
        }
        
        $clean['username'] = $this->_sanitize->stripTagsEncode($username);
        $mysql['username'] = $this->_db->real_escape_string($clean['username']);
        $sql = sprintf("SELECT id FROM `%susers` WHERE username = '%s' LIMIT 1", Database::getTablePrefix(), $mysql['username']);
        
        $exists = false;
        
        $query = $this->_db->query($sql);
        $data = $query->fetch_assoc();
        
        if(count($data) > 0) {
            $exists = true;
        }
        
        $this->_db->close();
        return $exists;
    }
    
    /***
    DESCRIPTION: Checks to see if a username belongs to a specific user id
    PRE:  @id (int), @username (string)
    POST: Boolean result is returned
    ***/
    public function usernameBelongsToUser($id = int, $username)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $username = stripslashes($username);
        }
        
        $clean['id'] = (int)$id;
        $clean['username'] = $this->_sanitize->stripTagsEncode($username);
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['username'] = $this->_db->real_escape_string($clean['username']);
        
        $sql = sprintf("SELECT id FROM `%susers` WHERE username = '%s' AND id = %s LIMIT 1", Database::getTablePrefix(), $mysql['username'], $mysql['id']);
        
        $belongsToUser = false;
        
        $query = $this->_db->query($sql);
        $data = $query->fetch_assoc();
        
        if(count($data) > 0) {
            $belongsToUser = true;
        }
        
        $this->_db->close();
        return $belongsToUser;
    }
    
    /***
    DESCRIPTION: updates user data
    PRE:  @id (int), @role_id (int), @username (string)
    POST: user is updated w/ new content
    ***/
    public function userUpdate($id = int, $role_id = int, $username)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $username = stripslashes($username);
            $role_id = stripslashes($role_id);
            $id = stripslashes($id);
        }
        
        $clean['id'] = (int)$id;
        $clean['role_id'] = (int)$role_id;
        $clean['username'] = $this->_sanitize->stripTagsEncode($username);
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['role_id'] = $this->_db->real_escape_string($clean['role_id']);
        $mysql['username'] = $this->_db->real_escape_string($clean['username']);
        
        $sql=sprintf("UPDATE `%susers` SET username = '%s', role_id = '%s' WHERE id = '%s'", Database::getTablePrefix(), $mysql['username'], $mysql['role_id'], $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
    }
    
    /***
    DESCRIPTION: updates user password
    PRE:  @password (string)
    POST: user password is updated
    ***/
    public function userUpdatePassword($id = int, $password)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $password = stripslashes($password);
            $id = stripslashes($id);
        }
        
        $clean['id'] = (int)$id;
        $clean['password'] = $this->_sanitize->stripTagsEncode($password);
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['password'] = $this->_db->real_escape_string(sha1($password));
        
        $sql=sprintf("UPDATE `%susers` SET password = '%s' WHERE id = '%s'", Database::getTablePrefix(), $mysql['password'], $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
    }
    
    /***
    DESCRIPTION: updates a users role id
    PRE:  @id (int), @role_id (int)
    POST: user role id is updated
    ***/
    public function userUpdateRoleId($id = int, $role_id = int)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $role_id = stripslashes($role_id);
            $id = stripslashes($id);
        }
        
        $clean['id'] = (int)$id;
        $clean['role_id'] = (int)$role_id;
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        $mysql['role_id'] = $this->_db->real_escape_string($clean['role_id']);
        
        $sql=sprintf("UPDATE `%susers` SET role_id = '%s' WHERE id = '%s'", Database::getTablePrefix(), $mysql['role_id'], $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
    }
    
    /***
    DESCRIPTION: deletes a user
    PRE:  @id (int)
    POST: user is removed from database
    ***/
    public function userDelete($id = int)
    {        
        $this->_db = Database::connect();
        
        $clean = array();
        $mysql = array();
        
        if (get_magic_quotes_gpc()) {
            $id = stripslashes($id);
        }
        
        $clean['id'] = (int)$id;
        
        $mysql['id'] = $this->_db->real_escape_string($clean['id']);
        
        $sql=sprintf("DELETE FROM `%susers` WHERE id = '%s'", Database::getTablePrefix(), $mysql['id']);
        $this->_db->query($sql);
        $this->_db->close();
    }
    
    /***
    DESCRIPTION: grabs all user roles
    POST: Returns the result set as encoded json
    ***/
    public function getUserRoles()
    {     
        $this->_db = Database::connect();
        
        $arr = array();
        
        //If porting this to another language the CONCAT statment needs to be modified to support
        //the include statement for ported language
        $sql = sprintf("SELECT id, role FROM `%sroles` ORDER BY role", Database::getTablePrefix());
        
        if($query = $this->_db->query($sql)) {
            while ($obj = $query->fetch_object()) {
                $arr[] = $obj;
            }
            
            /*
            * Sanitize user roles prior to output
            */
            foreach($arr as &$value) {              
                $value->id = (int)$value->id;
                $value->role = $this->_sanitize->stripTagsEncode($value->role);
            }
            
            $query->close();
        }        
        
        $this->_db->close();
        
        return '{"results":' . json_encode($arr) . '}';
    }
    
    /***
    DESCRIPTION: grabs all users
    POST: Returns the result set as encoded json
    NOTE: This is a bit convuluted, therefore an example json result set can be seen
    at admin/action/users.json
    ***/
    public function getUsers()
    {     
        $this->_db = Database::connect();
        
        $json = '[';
        
        $sql = sprintf("SELECT id, role FROM `%sroles` ORDER BY id", Database::getTablePrefix());
        
        if($query = $this->_db->query($sql)) {
            $i = 1;
            while ($row = $query->fetch_assoc()) {
                //a bit of formatting to ensure commas are in their correct places
                $i++ != 1 ? $json .= ',{' : $json .= '{';
                
                $json .= "text: '" . ucfirst($this->_sanitize->stripTagsEncode($row['role'])) . "',";
                $json .= "id: '" . $row['id'] . ucfirst($this->_sanitize->stripTagsEncode($row['role'])) . "s',";
                $json .= "expanded: true,";
                $json .= "draggable: false,";
                $json .= "children: [";
                
                $sql2 = sprintf("SELECT id, username FROM `%susers` WHERE role_id = %s ORDER BY username", Database::getTablePrefix(), $this->_sanitize->stripTagsEncode($row['id']));
                
                if($query2 = $this->_db->query($sql2)) {
                    $j = 1;
                    while ($row2 = $query2->fetch_assoc()) {
                        $j++ != 1 ? $json .= ',{' : $json .= '{';
                                  
                        $json .= "text: '" . $this->_sanitize->stripTagsEncode($row2['username']) . "',";
                        $json .= "id: '" . $this->_sanitize->stripTagsEncode($row2['id']) . "node',";
                        $json .= "iconCls: 'icon-" . strtolower($this->_sanitize->stripTagsEncode($row['role'])) . "',";
                        
                        //do not allow admins to move editors or adminstrators between roles
                        //do not allow administrators to move themselves between roles
                        if($row2['username'] == 'admin' || $row2['username'] == 'editor' || $_SESSION['username'] == $row2['username']) {
                            $json .= "draggable: false,";
                        } else {
                            $json .= "draggable: true,";
                        }
                        
                        $json .= "leaf: true";
                        $json .= '}';
                    }
                    
                    $query2->close();
                }
                
                $json .= ']}';
            }
            
            $query->close();
        }
        
        $json .= ']';
        
        $this->_db->close();
        
        return $json;
    }
}