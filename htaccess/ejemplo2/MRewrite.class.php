<?
/*
	author: ivi
	email: ivi@newsroot.net
	www: http://newsroot.net
*/

	class Rewrite
	{
		var $url ='';
		var $urlArr = array();
		var $query  = '';
		var $path  = '';
		var $file = '';
		var $newpath  ='';
		var $newpath1  ='';		
		var $host  = '';		
		var $error  = 0;
		
		function Rewrite($url)
		{
			$this->url = $url;
			$this->urlArr = parse_url($url);
			$this->host = $this->urlArr['host'];
			if($this->urlArr['port'] != '')
				$this->host .= ':' .$this->urlArr['port'];
			$this->parse();
			$this->host .= $this->newpath;
		}
		
		
		function parse()
		{
			$this->query  = trim($this->urlArr['query']);
			if($this->query == '')
				$this->error = 1;
			$this->path = trim($this->urlArr['path']);
			$path  = $this->parsePath($this->path);
			if($path != '')
			{
				$tmpArr  = explode(".",$path);
				if(trim($tmpArr[0]) != '')
					$this->file = trim($tmpArr[0]);
			}
			if($this->file != '')
			{
				$this->newpath = dirname($this->path);
			}
			else 
			{
				$this->newpath = $this->path;
			}
			$this->newpath1 = $this->newpath;
			if(substr($this->newpath1,strlen($this->newpath1)-1,1) != '/')
				$this->newpath1 .='/';
		}
		
		function parsePath($path)
		{
			$arr  = explode("/",$path);
			if(sizeof($arr) <= 0)
				return '';
			return trim( array_pop($arr));
		}
		
		
		function getOut($arr)
		{
			return "
Options +FollowSymLinks
RewriteEngine on
RewriteRule " . $arr['rule'] . "  ". $arr['out'];
		}
		
		function getType1()
		{
			$str  = $this->query;
			$rewriteStr = '';
			$rewriteSpl = '';
			$rewriteSpl1 = '';
			$out  = '';
			
			$arr  = explode("&",$str);
			if(sizeof($arr) <= 0)
				return array();
			$index  =0;
			foreach ($arr as $var)
			{
				$index ++;
				$varArr = explode("=",$var);
				if($rewriteStr == '')
				{
					$rewriteStr .=$varArr[0]."-(.*)";
					$rewriteSpl .=$varArr[0]."-$varArr[1]";
					$rewriteSpl1 .=$varArr[0]."-(Your Value)";
					$out  .= $varArr[0].'='.'$'.$index.'&';
					
				}
				else 
				{
					$rewriteStr .= '-'.$varArr[0]."-(.*)";
					$rewriteSpl .= '-'.$varArr[0]."-$varArr[1]";
					$rewriteSpl1 .= '-'.$varArr[0]."-(Your Value)";
					$out  .= $varArr[0].'='.'$'.$index.'&';
				}
			}
			if(trim($this->file) != '')
			{
				$rewriteStr =$this->file.'-'.$rewriteStr."\\.htm$";
				$rewriteSpl =$this->file.'-'.$rewriteSpl.".htm";
				$rewriteSpl1 =$this->file.'-'.$rewriteSpl1.".htm";
				
			}
			else 
			{
				$rewriteStr =$this->file.$rewriteStr."\\.htm$";
				$rewriteSpl =$this->file.$rewriteSpl.".htm";
				$rewriteSpl1 =$this->file.$rewriteSpl1.".htm";
				
			}
			
			$arr  = array();
			$arr['out'] = $this->path.'?' .$out;
			$arr['rule'] = $rewriteStr;
			$arr['expl'] = $rewriteSpl;
			if($this->urlArr['port'] != '')
				$arr['fexpl'] = $this->urlArr['host'].':'.$this->urlArr['port'].$this->newpath1. $rewriteSpl1;
			else
				$arr['fexpl'] = $this->urlArr['host'].$this->newpath1. $rewriteSpl1;
			if($this->urlArr['scheme'] != '')
				$arr['fexpl'] = $this->urlArr['scheme'].'://'.$arr['fexpl'] ;
			
			return $arr;
			
			//dump($arr);
		}
		
		
		function getType2()
		{
			$str  = $this->query;
			$rewriteStr = '';
			$rewriteSpl = '';
			$rewriteSpl1 = '';
			$out  = '';
			
			$arr  = explode("&",$str);
			if(sizeof($arr) <= 0)
				return array();
			$index  =0;
			foreach ($arr as $var)
			{
				$index  ++;
				$varArr = explode("=",$var);
				if($rewriteStr == '')
				{
					$rewriteStr .=$varArr[0]."/(.*)/";
					$rewriteSpl .=$varArr[0]."/$varArr[1]/";
					$rewriteSpl1 .=$varArr[0]."/(Any Value)/";
					$out  .= $varArr[0].'='.'$'.$index.'&';
					
				}
				else 
				{
					$rewriteStr .= $varArr[0]."/(.*)/";
					$rewriteSpl .= $varArr[0]."/$varArr[1]/";
					$rewriteSpl1 .= $varArr[0]."/(Any Value)/";
					$out  .= $varArr[0].'='.'$'.$index.'&';
				}
			}
			if(trim($this->file) != '')
			{
				$rewriteStr =$this->file.'/'.$rewriteStr;
				$rewriteSpl =$this->file.'/'.$rewriteSpl;
				$rewriteSpl1 =$this->file.'/'.$rewriteSpl1;
				
			}
			else 
			{
				$rewriteStr =$this->file.$rewriteStr;
				$rewriteSpl =$this->file.$rewriteSpl;
				$rewriteSpl1 =$this->file.$rewriteSpl1;
				
			}
			
			$arr  = array();			
			$arr['out'] = $this->path.'?' .$out;			
			$arr['rule'] = $rewriteStr;
			$arr['expl'] = $rewriteSpl;			
			if($this->urlArr['port'] != '')
				$arr['fexpl'] = $this->urlArr['host'].':'.$this->urlArr['port'].$this->newpath1. $rewriteSpl1;
			else
				$arr['fexpl'] = $this->urlArr['host'].$this->newpath1. $rewriteSpl1;
			if($this->urlArr['scheme'] != '')
				$arr['fexpl'] = $this->urlArr['scheme'].'://'.$arr['fexpl'] ;
			return $arr;			
		}
	}

?>