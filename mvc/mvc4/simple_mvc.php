<?php

	/*
	 * Simple MVC Framework
	 * Design patern is based in codeigniter
	*/

	abstract class simple_mvc {

		abstract protected function main();

		public function simple_mvc(){
			ob_start();
			if(method_exists($this,"main")) $this->main();
			$this->__pages();
		}

		/*
		 * method to add a view page
		 */
		protected function view($view,$vars=array()){
			$view = str_replace('.tpl.php','',$view);
			$GLOBALS['output'] = ob_get_contents();
			$GLOBALS = array_merge($GLOBALS,$vars);
			@ob_end_clean();
			include("$view.tpl.php");
		}

		/*
	     * method to import a class file
		 */
		protected function import($class){
			include("$class.php");
			$class = str_replace('/','',substr($class,strrpos($class,'/')));
			$this->$class =new $class();
		}

		/*
		 * route the controller to specific page method
		 */
		private function __pages(){
			$get_name = getenv('PATH_INFO');
			$get_name = str_replace(' ','_',str_replace('/','',$get_name));
			if(method_exists($this,"{$get_name}")){
				$this->$get_name();
			}elseif(empty($get_name)){
				if(method_exists($this,"index")) $this->index();
			}
		}
	}


	/*
	 * function that create an instance of a controller
	 */
	function Run($controller){
		include_once("$controller.php");
		echo ('Controller: '.$controller);
		$controller = str_replace('/','',substr($controller,strrpos($controller,'/')));
		return (new $controller());
	}

	/*
	 * function for view, display a data from the controller
	 */
	function Output($var=""){
		if(isset($GLOBALS[$var])){
			print $GLOBALS[$var];
		}elseif(empty($var) && isset($GLOBALS['output'])){
			print $GLOBALS['output'];
		}
	}

#_END