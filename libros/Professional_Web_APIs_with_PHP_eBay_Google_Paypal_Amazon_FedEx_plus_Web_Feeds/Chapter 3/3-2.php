<?php
	//Page 25

  include("./minixml.inc.php");
  $request = "http://rss.news.yahoo.com/rss/software";
  $response = file_get_contents($request);
  
  $parsedDoc = new MiniXMLDoc();

	$parsedDoc->fromString($response);
  
  $rootEl =& $parsedDoc->getRoot();
  
  $title = $rootEl->getElementByPath('channel/title');
  echo "<h1>" . $title->getValue() . "</h1>";
  
  $returnedElement =& $rootEl->getElement('channel');
  
  $elChildren =& $returnedElement->getAllChildren();
	
	for($i = 0; $i < $returnedElement->numChildren(); $i++)
	{
		if ($elChildren[$i]->name() == 'item')
		{
			$link = $elChildren[$i]->getElementByPath('link');
			$title = $elChildren[$i]->getElementByPath('title');
			$desc = $elChildren[$i]->getElementByPath('description');
			
			echo "<a href=\"" . $link->getValue() . "\">" . html_entity_decode($title->getValue()) . "</a><br>";
			echo "<p>" . html_entity_decode($desc->getValue()) . "</p><br><br>";
		}

	}
	
?>