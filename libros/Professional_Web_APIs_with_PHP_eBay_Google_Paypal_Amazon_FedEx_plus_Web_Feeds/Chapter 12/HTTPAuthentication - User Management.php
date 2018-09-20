<?php
function createUser($username, $password)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $r1 = rand(1, strlen($chars) - 1);
  $r2 = rand(1, strlen($chars) - 1);
  $salt = substr($chars, $r1, 1) . substr($chars, $r2, 1);
  $saltedPassword = crypt($password, $salt);
  $resource = dba_open("/www/basicAuth/api.example.com/passwords.dat", "c", "db4");
  if (dba_insert($username, $saltedPassword, $resource))
  {
    dba_close($resource);
    return true;
  }else
  {
    dba_close($resource);
    return fales;
  }
}

function deleteUser($user)
{
  $resource = dba_open("/www/basicAuth/api.example.com/passwords.dat", "c", "db4");
  dba_delete($user, $resource);
  dba_close($resource);
}

?>
