<?php 
/**
 * Example using of SimpleCrawler class library
 */

require 'simple_crawler.classes.php';
$reader = new HtmlReader();
//$page = 'http://www.milanuncios.com/pajaros-en-barcelona/ninfa.htm?demanda=n&vendedor=part';
//$page = 'http://www.davidberruezo.com';
$page = 'http://almacenanimal.com/es/12-aves';
//$page = 'http://www.phpclasses.org';
//read  content from url
$html = $reader->getPageContent($page);
//document content object
$htmlDoc = new HtmlDocument($html);
//document body part object
$body = $htmlDoc->getBody();
//objects array of page links
$links = $body->grabLinks();
//clean text version of document body object
$cleanBody = $body->getStrippedBody();
//counted words from cleaned document body (word=>count)
$words = new BodyWords();
$pageWords = $words->findWords($cleanBody->getContent());
$words->appendWords($pageWords);
//follow front page links with recursive=1
foreach($links as $link) {
	if($link->url == '/') continue;
	if($link->type == 1) {
		$pageLink = $page.$link->url;
	} else {
		continue; //no follow external links
		//$pageLink = $link->url;
	}
	$html = $reader->getPageContent($pageLink);
	$htmlDoc = new HtmlDocument($html);
	$body = $htmlDoc->getBody();
	$cleanBody = $body->getStrippedBody();
	$pageWords = $words->findWords($cleanBody->getContent());
	$words->appendWords($pageWords, $link->url);
}

//display words:count per page
print_r($words->getWords());
//here you may do something with this words
?>