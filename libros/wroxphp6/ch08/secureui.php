<?php
require_once ('class.Dispatcher.php');
session_start();
?>
<html>
   <head>
      <title>Secure, Event Driven Record Viewer!</title>
   </head>
   <body>
      <form method="GET" ACTION="<?=$_SERVER['PHP_SELF']?>">
         <input type="submit" name="event" value="View" />
         <input type="submit" name="event" value="Edit" />
      </form>
   </body>
</html>
<?php
function handle() {
   $event = $_GET['event'];
   $disp = new dispatcher($event);
   $disp->handle_the_event();
}
$_SESSION['name'] = "Horatio";
handle();
?>