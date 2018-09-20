{include file="header.tpl" title="Widget World Login"}
<h3>Please Login:</h3> <p>
{section name=one loop=$error}{sectionelse}
  <font color="#FF0000">{$error}</font><p>
{/section}
<form action="index.php" method="post">
 <table border="0">
  <tr>
    <td width="20"></td>
    <td>User:</td>
    <td><input name="login_name" type="text" size="20" maxsize="50"></td>
  </tr>
  <tr>
     <td width="20"></td>
     <td>Password:</td>
     <td><input name="login_pass" type="password" size="20" maxsize="50"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td></td>     
    <td><input type="submit" value=" Login "></td>
  </tr>
 </table>
 <input type="hidden" name="action" value="login">
</form>
{include file="footer.tpl"}