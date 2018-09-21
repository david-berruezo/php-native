<?php
 /**
  * @author: Mick Sear, eCreate, 2005
  * 
  * You'll want to add in some authentication here first of all, probably
  * in the form of a login page that submits a username and password to this
  * page, which then checks its validity.
  * 
  * You'll also need to supply your database connection details.  See the 
  * readme.txt file for database setup SQL.
  */
 
 session_start();
 
 require_once("classes/Templater.php");
 require_once("classes/Channels.php");
 require_once("classes/Database.php");
 require_once("config.php");

 $template = "templates/admin.htm";
 
 $db = new db($dbhost, $dbusername, $dbpass, $database);
 $channels = new Channels();           
  
 //My usual format, one page for all operations on a 'thing', 
 //using switch on a GET param to decide what to do
 switch($_GET['action']){
     case "edit":
        $html = $channels->renderEdit($_GET['id'], $_SERVER['PHP_SELF']."?action=update");
        $out['content'] = $html['content'];
        break;
     
     case "new":                          
        $html = $channels->renderEdit(0, $_SERVER['PHP_SELF']."?action=save");
        $out['content'] = $html['content'];
        break;
        
     case "save":
        $channels->save(   $_POST['channel'], 
                        $_POST['description']);
        header("Location: manage_channels.php");
        exit;        
        
     case "update":
        $channels->update( $_POST['id'], 
                        $_POST['channel'], 
                        $_POST['description']);
        header("Location: manage_channels.php");
        exit;
                
     case "delete":
        $channels->delete($_GET['id']);
        header("Location: manage_channels.php");
        exit;
        
     default:            
        $out['content'] .= "<a href='manage_channels.php?action=new'>Add a new channel</a>";
         
        $arChannels = $channels->getList();        
               
        //Now list them.
        $out['content'] .= "<div id='blogListing'><ul>
        <li>           
            <div class='url th'>Name</div>
            <div class='url th'>Description</div>
            <div class='link th'>Action</div>            
        <br /></li>";
                
        if (isset($arChannels)){
            foreach($arChannels as $row){
                $out['content'] .= "<li>";
                $out['content'] .= "
                    <div class='url'>".$row['name']."</div>"
                    ."<div class='url'>".stripslashes($row['description'])."</div>"
                    ."<div class='link'><a href='manage_channels.php?action=edit&id=".
                    $row['id']."'>Edit</a> | <a href='manage_channels.php?action=delete&id=".
                    $row['id']."'>Delete</a> | ";                
                $out['content'] .= "</div><br />"; 
                $out['content'] .= "</li>";
            }
        }
        $out['content'] .= "</ul></div>";
        break;
 }
 
 $out['debug'] .= $channels->getDebug();
 
 //Templating.  $out is an associative array of placeholders=>content
 $t = new ms_template($template, $out, "<!--::", "::-->");
 $t->parse();
 $t->display();
 ?>