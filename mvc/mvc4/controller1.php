<?php
	/*
		Sample Controller
	*/
	class controller1 extends simple_mvc {
		protected function main(){
			$this->import('model1'); # create an instance of model1 class
		}
		protected function index(){
			print $this->model1->home_content();
			$var['content'] = "home page contents";
			$this->view('view1',$var);
		}
		protected function portfolio(){
			print $this->model1->other_content("portfolio");
			$var['content'] = "portfolio page contents";
			$this->view('view1',$var);
		}
		protected function downloads(){
			print $this->model1->other_content("downloads");
			$var['content'] = "downloads page contents";
			$this->view('view1',$var);
		}
		protected function contacts(){
			print $this->model1->other_content("contacts");
			$var['content'] = "contacts page contents";
			$this->view('view1',$var);
		}
	}
#_END