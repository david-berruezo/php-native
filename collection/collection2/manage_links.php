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
 require_once("classes/Links.php");
 require_once("classes/Channels.php");
 require_once("classes/Database.php");
 require_once("config.php");

 $template = "templates/admin.htm";
 
 $db = new db($dbhost, $dbusername, $dbpass, $database);
 $links = new Links();       
 $channels = new Channels();
  
 //My usual format, one page for all operations on a 'thing', 
 //using switch on a GET param to decide what to do
 switch($_GET['action']){
     case "edit":
        $html = $links->renderEdit($_GET['id'], $_SERVER['PHP_SELF']."?action=update");
        $out['content'] = $html['content'];
        break;
     
     case "new":                          
        $html = $links->renderEdit(0, $_SERVER['PHP_SELF']."?action=save");
        $out['content'] = $html['content'];
        break;
        
     case "save":
        $links->save(   $_POST['url'], 
                        $_POST['description'], 
                        $_POST['enabled'], 
                        $_POST['channel'], 
                        $_POST['keywords'], 
                        $_POST['rating']);
        header("Location: manage_links.php");
        exit;        
        
     case "update":
        $links->update( $_POST['id'], 
                        $_POST['url'], 
                        $_POST['description'], 
                        $_POST['enabled'], 
                        $_POST['channel'], 
                        $_POST['keywords'], 
                        $_POST['rating']);
        header("Location: manage_links.php");
        exit;
                
     case "delete":
        $links->delete($_GET['id']);
        header("Location: manage_links.php");
        exit;
        
     default:            
        $out['content'] .= "<a href='manage_links.php?action=new'>Add a new link</a>";
     
        //Could add pagination here easily.
        $start = 0;
        $num = 200;
     
        if ($_SESSION['username'] == "admin"){
            $arLinks = $links->getList($start, $num, "", "", $_GET['channel']);
        } else {
            $arLinks = $links->getList($start, $num, "", "", $_GET['channel']);
        }
        
        //Build a filtering channel select box
        $selectBox = $channels->getChannelSelectForm($_GET['channel']);        
        
        //Now list them.
        $out['content'] .= "<div id='blogListing'><ul>
        <li>           
            <div class='url th'>URL</div>
            <div class='url th'>Description</div>
            <div class='author th'>$selectBox</div>
            <div class='status th'>Rating</div>
            <div class='link th'>Action</div>
            <div class='status th'>Status</div>
        <br /></li>";
                
        if (isset($arLinks)){
            foreach($arLinks as $row){
                if (isset($_GET['channel']) && $_GET['channel'] != $row['channel']){
                    continue;
                }
                $out['content'] .= "<li>";
                $out['content'] .= "
                    <div class='url'>".$row['url']."</div>"
                    ."<div class='url'>".stripslashes($row['description'])."</div>"
                    ."<div class='author'>".$row['channel']."&nbsp;</div>"
                    ."<div class='status'>".$row['rating']."&nbsp;</div>"
                    ."<div class='link'><a href='manage_links.php?action=edit&id=".
                    $row['id']."'>Edit</a> | <a href='manage_links.php?action=delete&id=".
                    $row['id']."'>Delete</a> | ";
                
                if ($links->isPublishFlagSet($row['id'])){
                    $out['content'] .= "<a href='manage_links.php?action=suspend&id=".$row['id']."'>Unpublish</a>";
                } else {
                    $out['content'] .= "<a href='manage_links.php?action=enable&id=".$row['id']."'>Publish</a>";
                }
                
                $out['content'] .= "</div><div class='status'>";
                
                if ($links->isPublishFlagSet($row['id'])){
                    $out['content'] .= "<img src='images/green.gif' alt='Entry is live' title='Entry is live' />";
                } else {
                    $out['content'] .= "<img src='images/red.gif' alt='Entry is not live (disabled)' title='Entry is not live (disabled)' />";
                }
                
                $out['content'] .= "</div><br />"; 
                $out['content'] .= "</li>";
            }
        }
        $out['content'] .= "</ul></div>";
        break;
        
     case "suspend":
        $links->suspend($_GET['id']);
        header("Location: manage_links.php");
        break;
     
     case "enable":
        $links->enable($_GET['id']);
        header("Location: manage_links.php");
        break;
 }
 
 $out['debug'] .= $links->getDebug();
 
 //Templating.  $out is an associative array of placeholders=>content
 $t = new ms_template($template, $out, "<!--::", "::-->");
 $t->parse();
 $t->display();
 ?>