<?php

/*
Channel class - encapsulates all you can do with a channel

@author: Mick Sear, eCreate, 2005
*/

require_once("Database.php");

class Channels{
    
    var $output = Array();
    var $db;
    var $table; 
    
    function Channels(){  
        global $dbhost, $dbusername, $dbpass, $database;
       
        $this->db = new db($dbhost, $dbusername, $dbpass, $database);
        $this->table = "channels";
    }
    
    function renderEdit($id=0, $formAction){
        
        $entry = $this->get($id);
                       
        $this->output['content'] = "
        <form action='$formAction', method='POST' class='editorForm'>
            <label for='url'>Channel Name:</label>
            <input type='text' name='channel' id='channel' class='title' 
            value='".stripslashes($entry['name'])."' /><hr />
            <label for='description'>Description:</label>
            <textarea name='description' id='description' class='short'>".
            stripslashes($entry['description'])."</textarea><hr />
            <input type='submit' name='submit' value='Save' />
            <input type='hidden' name='id' id='id' value='".$id."' />
        </form><br />";
        return $this->output;        
    }
    
    function delete($id){
        $id = (int) $id;
        $q = "delete from ".$this->table." where id=".$id;
        @ mysql_query($q, $this->db->conn);
    }
    
    function save($channel, $description){
        $channel = mysql_escape_string($channel);
        $description = addslashes($description);
              
        $q = "insert into ".$this->table." 
            (id, name , description) 
            values 
            ('',
            '".$channel."',
            '".$description."')";
        $r = mysql_query($q, $this->db->conn);
        $this->debug .= "Saving channel: ".$q."<br />";
    }
    
    function update($id, $channel, $description){
        $id = (int) $id;
        $channel = mysql_escape_string($channel);
        $description = addslashes($description);
      
        $q = "update ".$this->table." set 
                name='".$channel."', 
                description='".$description."'
                where id=".$id;
               
        $r = mysql_query($q, $this->db->conn);
    }
    
    /*Get a specific blog or news item 
    Returns an array of info about the entry or empty if entry doesn't exist*/
    function get($id){
        $id = (int) $id;
        $q = "select * from ".$this->table." where id=".$id." limit 1";
        $entry = @ mysql_fetch_array(mysql_query($q, $this->db->conn));
        if (!isset($entry)){
            $entry['name'] = "";
            $entry['description'] = "";
        }
        return $entry;
    }
    
    function getChannelSelectBox($current){
        //Build a filtering channel select box
        $selectBox = "
        <select name='channel' id='channel'onChange='this.form.submit();' style='width: 80px;'>";
        $q = "select * from channels order by name asc";
        $r = @ mysql_query($q, $this->db->conn);
        while($row = @ mysql_fetch_array($r)){
            if ($current == $row['name']){
                $selectBox .= "<option value='".$row['name']."' selected>".$row['name']."</option>";
            } else {
                $selectBox .= "<option value='".$row['name']."'>".$row['name']."</option>";
            }
        }
        $selectBox .= "</select>"; 
        return $selectBox;
    }
    
    function getChannelSelectForm($current){
        //Build a filtering channel select box
        $selectForm = "
        <form name='channel' method='get' action='manage_links.php' 
        style='height: auto;border: 0;margin: 0; padding: 0;'>";
        $selectForm .= $this->getChannelSelectbox($current);
        $selectForm .= "</form>"; 
        return $selectForm;
    }
    
    function getList(){
        $entries = Array();
        $q = "select * from channels order by name asc";
        $r = @ mysql_query($q, $this->db->conn);
        while($row = mysql_fetch_array($r)){
            $entries[] = $row;
        }
        return $entries;
    }
    
    function getDebug(){
        return $this->debug;
    }
}
?>