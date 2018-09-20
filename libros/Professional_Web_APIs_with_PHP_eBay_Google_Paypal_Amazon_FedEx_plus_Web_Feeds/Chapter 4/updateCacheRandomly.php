<?php
function cacheIsRecentRandom()
{
  if (rand(0, 71) == 42)
  {
    return false; 
  }else
  {
    return true;
  }
}
?>