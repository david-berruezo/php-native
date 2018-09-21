<?
/**
 * @author Henrico Robinson
 */

set_time_limit(300);
include_once("WordSeperators.php");

class Crawler2{
	
	var $links;
	var $server;
	var $searchtext;
	var $content;
	var $thelink;
	var $islink=false;
	var $waitingq;
	var $linkindi = Array(0 => Array("tag"=>" a ","link"=>"href"),1 => Array("tag"=>"<a ","link"=>"href"),2=> Array("tag"=>"frame","link"=>"src"),3=> Array("tag"=>"iframe","link"=>"src"));
	
	
	function __Construct($url,$searchtext=""){
		$this->waitingq[]="";
		array_shift($this->waitingq);
		$s = new URL($url);
		$this->server=$s->server;
		$this->searchtext=$searchtext;
		$this->crawl($s);
		}
		
	function crawl($url){
		
		if ($this->searchtext!="") if ($this->islink) return;
			
		$plinks=$this->getLinks($url->getString());
		
		if ($this->searchtext!="") if ($this->isLink($url)) return;
			
		$plinks=$this->addServer($plinks);
		
		for ($r=0;$r<count($plinks);$r++){
			$found=false;
			try{
				
			$t=new URL($plinks[$r]);

			for ($z=0;$z<count($this->links);$z++)
				if ($this->links[$z]==$t->getString()){
					$found=true;
					break;
					}
					
			if (!$found){
				$this->links[]=$t->getString();
				$founds[]=$t;
				}
			} catch(InvalidURLException $e){}
			}
		
		for ($r=0;$r<count($founds);$r++){
			if ($this->server==$founds[$r]->server){
				$found=false;
				for ($z=0;$z<count($this->waitingq);$z++)
					if ($this->waitingq[$z]->getString()==$founds[$r]){
						$found=true;
						break;
						}		
				if (!$found)$this->waitingq[]=$founds[$r];
				
			}
		}
		
		$u=array_shift($this->waitingq);
		if ($u!=null) $this->Crawl($u);
		
		}
		
	function isLink($url){
		if (strpos($this->content,$this->searchtext)){
			$this->islink=true;
			$this->thelink=$url->getString();
			}
		}
		
	function addServer($l){
		
		for ($r=0;$r<count($l);$r++){
			$l[$r]=$this->server."/".$l[$r];
			}
			
		return $l;
		
		}
		
	function getPageContent($page){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$page);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		$this->content=$data;
		return $data;
		}
		
	function getLinks($page){
		$content=$this->getPageContent($page);
		if ($content=="") return null;
		
		for ($z=0;$z<count($this->linkindi);$z++){
			
			$p=strpos($content,$this->linkindi[$z]["tag"]);
			$p=strpos($content,$this->linkindi[$z]["link"],$p);
			while($p){
			
				while ($content[$p]!="=") $p++;
				$p++;
				while ($this->isASpaceFromString($content,$p))$p++;
			
				if ($content[$p]=="\"") $mark="\"";
				else if ($content[$p]=="'") $mark="'";
				else $mark=" ";
			
				if ($mark!=" ") $p++;
			
				$ret="";
			
				while ((($mark==" ")&&((!$this->isASpaceFromString($content,$p))&&($content[$p]!=">")))||(($mark!=" ")&&($content[$p]!=$mark))){
					$ret.=$content[$p];
					$p++;
					}
				
				$rets[]=$ret;
			
				$p=strpos($content,$this->linkindi[$z]["tag"],$p+1);
				if (!$p) break;
			
				$p=strpos($content,$this->linkindi[$z]["link"],$p);
			}
		}
		return $this->filter($this->removeFrontMark($this->removeURL($this->paramonly($rets,$page))));
		
		}
		
	function paramonly($l,$page){
		$u=new URL($page);
		for ($r=0;$r<count($l);$r++){
			if ($l[$r][0]=="?") $l[$r]=$u->dir."/".$u->page.$l[$r];
			}
		return $l;
		}
		
	function removeURL($l){
		for ($r=0;$r<count($l);$r++){
			try{
				
				$u = new URL($l[$r]);
				$l[$r]=$u->dir."/".$u->page;
				if ($u->parameters!="") $l[$r].="?".$u->parameters;
				
				}
			catch(InvalidURLException $e){}
			}
		return $l;
		}
		
	function removeFrontMark($l){
		
		for ($r=0;$r<count($l);$r++){
			if ($l[$r][0]=="/") $l[$r]=substr($l[$r],1);
			}
			
		return $l;
		
		}
		
	function isASpaceFromString($str,$pos){

		global $Seperator;
		
		for ($i=0;$i<count($Seperator);$i++){
			if ($str[$pos]==$Seperator[$i]) return true;
			}
			
		return false;
		
		}
		
	function filter($l){
		
		if (count($l)==0) return $l;
		
		$ret[]=$l[0];
		
		for ($r=1;$r<count($l);$r++){
			$found=false;
			
			for ($z=0;$z<count($ret);$z++)
				if ($ret[$z]==$l[$r]){
					$found=true;
					break;
					}
					
			if (!$found) $ret[]=$l[$r];
			
			}
			
		return $ret;
		
		}
		
	function getAllLinks(){
		return $this->links;
		}
			
	}
	
class URL {
	
	var $server;
	var $dir;
	var $page;
	var $parameters;
	
	function __Construct($string){
		
		if (strpos($string,"http://")===0) $string=substr($string,7);
		if (strpos($string,"https://")===0) $string=substr($string,8);
		if ((!strpos($string,".com"))&&(!strpos($string,".edu"))&&(!strpos($string,".gov"))&&(!strpos($string,".int"))&&(!strpos($string,".mil"))&&(!strpos($string,".net"))&&(!strpos($string,".org"))&&(!strpos($string,".pro"))&&(!strpos($string,".biz"))&&(!strpos($string,".info"))&&(!strpos($string,".aero"))&&(!strpos($string,".museum"))&&(!strpos($string,".coop"))&&(!strpos($string,".co")))
			throw new InvalidURLException();
		$p=strpos($string,"?");
		if ($p){ $this->parameters=substr($string,$p+1); $string=substr($string,0,$p);}
		else{
			if ((!strpos($string,"/"))||($this->isDir($string))){
				$string.="/";
				}
			}
		
		$p=strpos($string,"/");
		if (!$p) throw new InvalidURLException();
		
		$this->server=substr($string,0,$p);
		
		$string=substr($string,$p+1);
		
		$string=$this->upstring($string);
		
		$p=strpos($string,"/");
		if ($p){
			$n=$p;
			while($n){
				$p=$n;
				$n=strpos($string,"/",$n+1);
				}
				
			$this->dir=substr($string,0,$p);
			$this->page=substr($string,$p+1);
		
			}
		else{
			$this->dir="";
			$this->page=$string;
			}
		
		}
		
	function isDir($string){
		
		$d=strpos($string,".");
		while($d){
			$prevd=$d;
			$d=strpos($string,".",$d+1);
			}
		if (!isset($prevd)) throw new InvalidURLException();
		
		$ld=$prevd;
		
		$d=strpos($string,"/");
		while($d){
			$prevs=$d;
			$d=strpos($string,"/",$d+1);
			}
		if (!isset($prevs)) return false;
		
		$ls=$prevs;
		return ($ls>$ld);
		
		}
		
	function upstring($string){
		
		$p=strpos($string,"../");
		while($p){
			
			$z=$p-1;
			while($string[$z]!="/"){ $z--; if ($z==0) throw new InvalidURLException();}
			$z--;
			while(($string[$z]!="/")&&($z>0)){ $z--;}
			$string=substr($string,0,$z)."/".substr($string,$p+3);
			
			$p=strpos($string,"../");
			}
			
		if ($string[0]=="/") $string=substr($string,1);
		return $string;
		
		}
		
	function getString(){
		
		if ($this->dir==""){
			if ($this->page=="") return $this->server;
			if ($this->parameters=="") return $this->server."/".$this->page;
			return $this->server."/".$this->page."?".$this->parameters;
			}
		
		if ($this->page=="") return $this->server."/".$this->dir."/";
		if ($this->parameters=="") return $this->server."/".$this->dir."/".$this->page;
		return $this->server."/".$this->dir."/".$this->page."?".$this->parameters;
		}
	
	}
	
class InvalidURLException extends Exception{}
