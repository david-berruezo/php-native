<?php
namespace com\net {

	/**
	 * Cookie is a simple object wrapper for PHP native setcookie function.
	 * If you create a cookie by specifying only the $name argument, the
	 * cookie will look for a stored value.
	 * 
	 * As a cookie is an additionnal HTTP header sent to the browser,
	 * no output should be made before calling the save method.
	 * 
	 * @package com.net
	 * @author rom
	 */
	class Cookie {

		/**
		 * The name of the cookie
		 * This string is a sequence of characters excluding semi-colon, comma and white space. 
		 * If there is a need to place such datarequired in the name or value, some encoding method such as URL style %XX encoding is recommended, 
		 * though no encoding is defined or required.
		 * @var string 
		 */
		public $name;
		
		/**
		 * The value of the cookie. 
		 * This value is stored on the clients computer; do not store sensitive information. 
		 * Assuming the name is 'cookiename', this value is retrieved through $_COOKIE['cookiename']
		 * @var string 
		 */
		public $value;
		
		/**
		 * The time the cookie expires. 
		 * This is a Unix timestamp so is in number of seconds since the epoch. 
		 * In other words, you'll most likely set this with the time() function plus the number of seconds before you want it to expire. 
		 * Or you might use mktime(). time()+60*60*24*30 will set the cookie to expire in 30 days. 
		 * If set to 0, or omitted, the cookie will expire at the end of the session (when the browser closes).
		 * @var int
		 */
		public $expire;
		
		/**
		 * The path on the server in which the cookie will be available on. 
		 * If set to '/', the cookie will be available within the entire domain. 
		 * If set to '/foo/', the cookie will only be available within the /foo/ directory 
		 * and all sub-directories such as /foo/bar/ of domain. 
		 * The default value is the current directory that the cookie is being set in.
		 * @var string 
		 */
		public $path;
		
		/**
		 * The domain that the cookie is available to. 
		 * To make the cookie available on all subdomains of example.com (including example.com itself) 
		 * then you'd set it to '.example.com'. Although some browsers will accept cookies 
		 * without the initial ., » RFC 2109 requires it to be included. 
		 * Setting the domain to 'www.example.com' or '.www.example.com' will make 
		 * the cookie only available in the www subdomain.
		 * @var string 
		 */
		public $domain;
		
		/**
		 * Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client. 
		 * When set to TRUE, the cookie will only be set if a secure connection exists. 
		 * On the server-side, it's on the programmer to send this kind of cookie only on secure connection 
		 * (e.g. with respect to $_SERVER["HTTPS"]).
		 * @var boolean
		 */
		public $secure;
		
		/**
		 * When TRUE the cookie will be made accessible only through the HTTP protocol. 
		 * This means that the cookie won't be accessible by scripting languages, such as JavaScript. 
		 * This setting can effectively help to reduce identity theft through XSS attacks 
		 * (although it is not supported by all browsers). 
		 * Added in PHP 5.2.0. TRUE or FALSE
		 * @var boolean
		 */
		public $httponly;
		
		/**
		 * Create a new Cookie
		 * 
		 * @param string $name The name of the cookie. 
		 * @param string $value [optional] The value of the cookie. 
		 * @param int $expire [optional] The time the cookie expires.
		 * @param string $path [optional] The path on the server in which the cookie will be available on. 
		 * @param string $domain [optional] The domain that the cookie is available to. 
		 * @param boolean $secure [optional] Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client. 
		 * @param boolean $httponly [optional] Indicates that the cookie will be made accessible only through the HTTP protocol
		 */
		public function __construct($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null){
			if(($this->name = (string) $name)){
				if(!is_null($value)){
					$this->value = (string) $value;
					$this->expire = $expire;
					$this->path = $path;
					$this->domain = $domain;
					$this->secure = $secure;
					$this->httponly = $httponly;
				} else {
					$this->value = $this->exists() ? $_COOKIE[$this->name] : '';
				}
			} else {
				throw new Exception("invalid cookie name");
			}
		}
		
		/**
		 * Verify the existence of the cookie regarding its name
		 * @return boolean
		 */
		public function exists(){
			return isset($_COOKIE[$this->name]);
		}
		
		/**
		 * Set the cookie by calling setcookie function
		 * @return boolean If output exists prior to calling this function, save will fail and return false. 
		 * If save successfully runs, it will return true. This does not indicate whether the user accepted the cookie.
		 */
		public function save(){
			return setcookie($this->name, $this->value, $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
		}
		
		/**
		 * Unset the cookie by calling setcookie function
		 * @return boolean If output exists prior to calling this function, save will fail and return false. 
		 * If save successfully runs, it will return true. 
		 */
		public function delete(){
			return setcookie($this->name, "", time() - 3600);
		}
	}

}
?>
