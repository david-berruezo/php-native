<?php
function cacheIsRecentTimeOfDay()
{
  if ((time() % (10 * 60)) == 0)
  {
  	return false;
  }else
  {
  	return true;
  }
}
?>