<?php

/*
Link class - encapsulates all you can do with a link (bookmark) 

@author: Mick Sear, eCreate, 2005
*/

require_once("Database.php");
require_once("Channels.php");

class Links{
    
    var $output = Array();
    var $db;
    var $table; 
    
    function Links(){  
        global $dbhost, $dbusername, $dbpass, $database;
       
        $this->db = new db($dbhost, $dbusername, $dbpass, $database);
        $this->table = "links";
    }
    
    /*Renders blog - can use variety of WYSIWYG editors, currently using TinyMCE*/
    function renderEdit($id=0, $formAction){
        
        $entry = $this->get($id);
               
        if ($entry['published'] == 1){
            $published = "checked";
        }
        
        if (!isset($entry['published'])){
            $published = "checked";//Publish by default
        }
        
        //Make channel select box
        $channels = new Channels();
        $selectBox = $channels->getChannelSelectBox($entry['channel']);;
        
        //Make rating select box
        $rating = "<select name='rating' id='rating'>";
        for($i=0;$i<=5;$i++){
            if ($entry['rating'] == $i){
                $rating .= "<option value='".$i."' selected>".$i."</option>";
            } else {
                $rating .= "<option value='".$i."'>".$i."</option>";
            }
        }
        $rating .= "</select>";
        
        $this->output['content'] = "
        <form action='$formAction', method='POST' class='editorForm'>
            <label for='author'>Channel: </label>".$selectBox."<hr />
            <label for='url'>Url:</label>
            <input type='text' name='url' id='url' class='title' 
            value='".stripslashes($entry['url'])."' /><hr />
            <label for='description'>Description:</label>
            <textarea name='description' id='description' class='short'>".stripslashes($entry['description'])."</textarea><hr />
            <label for='enabled'>Publish:</label>
            <input type='checkbox' name='enabled' id='enabled' ".$published." /><hr />
            <label for='keywords'>Keywords:</label>
            <textarea name='keywords' id='keywords' class='short'>".stripslashes($entry['keywords'])."</textarea><hr />
            <label for='rating'>Rating:</label>
            ".$rating."<hr />
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
    
    function save($url, $description, $enabled, $channel, $keywords, $rating){
        $url = mysql_escape_string($url);
        $description = addslashes($description);
        $channel = addslashes($channel);
        $keywords = addslashes($keywords);
        $rating = (int) $rating;
        
        if ($enabled == "on"){$enabled = 1;}//Checkbox formfield cones through like this
        $enabled = (int) $enabled;
              
        $q = "insert into ".$this->table." 
            (id , url , description , rating , channel , keywords , published) 
            values 
            ('',
            '".$url."',
            '".$description."',
            ".$rating.",
            '".$channel."',
            '".$keywords."',
            '".$enabled."')";
        $r = mysql_query($q, $this->db->conn);
        $this->debug .= "Saving link: ".$q."<br />";
    }
    
    function update($id, $url, $description, $enabled, $channel, $keywords, $rating){
        $id = (int) $id;
        $url = mysql_escape_string($url);
        $description = addslashes($description);
        $channel = addslashes($channel);
        $keywords = addslashes($keywords);
        $rating = (int) $rating;
        
        if ($enabled == "on"){$enabled = 1;}//Checkbox formfield cones through like this
        $enabled = (int) $enabled;
      
        $q = "update ".$this->table." set 
                url='".$url."', 
                description='".$description."', 
                rating=".$rating.", 
                channel='".$channel."',
                keywords='".$keywords."',
                published='".$enabled."'
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
            $entry['url'] = "";
            $entry['description'] = "";
        }
        return $entry;
    }
    
    /*Return an array of rows from the DB*/
    function getList($start, $num, $rating="", $author="", $channel=""){
        $start = (int) $start;
        $num = (int) $num;
        $author = mysql_escape_string($author);
        $channel = mysql_escape_string($channel);
        if ($rating != "" || $channel != "" || $author != ""){
            $where = " where 1 ";
        }        
        if ($rating != ""){
            $where .= " and rating='".$rating."' ";
        }
        if ($channel != ""){
            $where .= " and channel='".$channel."' ";
        }
        if ($author != ""){
            $where .= " and author='".$author."' ";
        }        
                
        $q = "select * from ".$this->table." ".$where." order by url desc limit ".$start.", ".$num;
        
        $this->debug .= "Getting links listing: ".$q."<br />";
        $entries_rs = @ mysql_query($q, $this->db->conn);
        $entries = Array();
        
        while($row = @ mysql_fetch_array($entries_rs)){
            $entries[] = $row;
        }
        return $entries;
    }
    
    
    function getDebug(){
        return $this->debug;
    }
    
   
    /*Doesn't check publish date - just shows whether blog is 'enabled'*/
    function isPublishFlagSet($id){
        $id = (int) $id;
        $q = "select published from ".$this->table." where id=".$id." limit 1";
        $row = @ mysql_fetch_array(mysql_query($q, $this->db->conn));
        
        if($row['published'] == 1){
            return true;
        } else { 
            return false;
        }
    }    
    
    function suspend($id){
        $id = (int) $id;
        $q = "update " . $this->table . " set published = 0 where id = " . $id;
        @ mysql_query($q, $this->db->conn);
    }
    
    function enable($id){
        $id = (int) $id;
        $q = "update " . $this->table . " set published = 1 where id = " . $id;
        @ mysql_query($q, $this->db->conn);
    }
    
    function displayChannel($channel){
        $q = "select * from ".$this->table." where channel='".mysql_escape_string($channel)."' order by url asc";
        $this->debug .= "Getting links listing: ".$q."<br />";
        $r = @ mysql_query($q, $this->db->conn);
        $ret = "<ul class='linkList'>";
        while($row = @ mysql_fetch_array($r)){
            $ret .= "
            <li>";
            $ret .= "<a href='".$row['url']."' title='".stripslashes($row['description'])."' target='new'>
            ".$row['url']."</a><img src='images/".$row['rating']."_stars.gif' alt='Rating: ".$row['rating']."' title='Rating: ".$row['rating']."' />
            <br /><span class='description'>".stripslashes($row['description'])."</span>";
            $ret .= "</li>
            ";
        }
        $ret .= "</ul>";
        return $ret;
    }
    
    function getByKeyword($keyword){
        //Use lazy method
        $ret = Array();
        $keywords = mysql_escape_string($keyword);
        $q = "select * from links where lower(keywords) like '%".$keyword."%'";
        $r = @ mysql_query($q, $this->db->conn);
        while($row = @ mysql_fetch_array($r)){
            $ret[] = $row;
        }
        return $ret;
    }
}

?>