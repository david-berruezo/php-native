<?php
//########################################################################################
// -------------- Summary
// This class stores some session data in a cookie on the user's computer, so when he comes
// back days later,the session data is reloaded from his cookie as if it was the same browsing session
// Example : 
// If you use session to store information about information a user entered on your website,
// for example items in a cart, it is important to not loose this information, so the cart is stored
// also as a cookie and if there is a problem on the site or on the client brownser, and the user comes
// back later, he can continue shopping.
//
// -------------- Author
// Logan Dugenoux - 2003
// logan.dugenoux@netcourrier.com
// http://www.peous.com/logan/
//
// -------------- License
// GPL
//
// -------------- Requirements
// PHP 4.0
//
// -------------- Methods :
// storeSessionCookie() 
// readSessionCookie() 
// storeSessionCookieOmit() 
// readSessionCookieOmit() 
//
// ------------- Example :
//
// Have fun !!!
//
//########################################################################################

	class cookieSession
	{
		var $cookName;
	
		function cookieSession() 
   		{
   			$this->cookName = "storeSessCook";
   		}
   		
		function setCookieName( $n ) 
   		{
   			$this->cookName = $n;
   		}
   		
   		
   		function storeSessionCookie( $arrayToStore ) 
   		{
   			global $HTTP_SESSION_VARS;
   			if (!is_array($arrayToStore))		$arrayToStore = array( $arrayToStore );
   			$cookValue =  "";
   			foreach( $arrayToStore as $k )
   			{
   				if (isset($HTTP_SESSION_VARS[$k]))
   				{
   					$cookValue .= base64_encode($k)."-".base64_encode(serialize($HTTP_SESSION_VARS[$k]))."|";
   				}
   			}
  			setcookie ( $this->cookName , $cookValue, time()+3600*24*365 );
   		}
   		
   		function storeSessionCookieOmit( $arrayToOmit ) 
   		{
   			global $HTTP_SESSION_VARS;
   			if (!is_array($arrayToOmit))		$arrayToOmit = array( $arrayToOmit );
			$toStore = array();
   			foreach( $HTTP_SESSION_VARS as $k => $v )
   			{
   				foreach( $arrayToOmit as $o )
   					if ($o == $k)
   						continue;
   				array_push($toStore, $k);
   			}
   			storeSessionCookie( $toStore );
   		}
   		
   		function readSessionCookie( $arrayToRead ) 
   		{
	   		global $HTTP_COOKIE_VARS;
   			global $HTTP_SESSION_VARS;
   			if (!is_array($arrayToRead))		$arrayToRead = array( $arrayToRead );
	   		$ckFields = explode( "|", $HTTP_COOKIE_VARS[$this->cookName] );
	   		if (is_array($ckFields))
	   		{
		   		foreach( $ckFields as $fld )
		   		{
		   		
		   			$oki = false;
		   			list($sName, $sVar) = explode( "-", $fld );
		   			$sName = base64_decode($sName);
	   				foreach( $arrayToRead as $o )
	   					if ($o == $sName)
	   						$oki = true;
	   				if ($oki)
	   					$HTTP_SESSION_VARS[ $sName ] = unserialize(base64_decode($sVar));
		   		}
		   	}
   		}

   		function readSessionCookieOmit( $arrayToOmit ) 
   		{
	   		global $HTTP_COOKIE_VARS;
   			global $HTTP_SESSION_VARS;
   			if (!is_array($arrayToOmit))		$arrayToOmit = array( $arrayToOmit );
	   		$ckFields = explode( "|", $HTTP_COOKIE_VARS[$this->cookName] );
	   		if (is_array($ckFields))
	   		{
		   		foreach( $ckFields as $fld )
		   		{
		   			list($sName, $sVar) = explode( "-", $fld );
		   			$sName = base64_decode($sName);
	   				foreach( $arrayToOmit as $o )
	   					if ($o == $sName)
	   						continue;
	   				$HTTP_SESSION_VARS[ $sName ] = unserialize(base64_decode($sVar));
		   		}
		   	}
   		}
	}
?>