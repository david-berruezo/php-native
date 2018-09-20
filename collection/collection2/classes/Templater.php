<?php
/*
Basic templating functionality
Mick Sear Nov 2004
*/
/**
 * Use: 
 * $t = new ms_template("template.htm", $assoc_array_content, "<:", ":>");
 * $t->parse();
 * $t->display();
 */
class ms_template{
   var $template="default.htm";
   var $template_dir = "./";
   var $output = "";
   //var $html_template;
   var $start_tag;
   var $end_tag;
   var $placeholders = array();
   var $edit_mode = false;
   
   /**
    * Constructor.  Sets the start and end tag markers and sets a few vars
    */
   function ms_template($html_template, $find_replace_array, $start_tag, $end_tag){
      if ($html_template){$this->template = $html_template;}else{$this->template ="default.htm";}
      if ($find_replace_array){$this->placeholders = $find_replace_array;}
      if ($start_tag){$this->start_tag = $start_tag;} else {$this->start_tag = "<!--::";}
      if ($end_tag){$this->end_tag = $end_tag;} else {$this->end_tag ="::-->";}
      $this->template_dir = "";
      $this->output = "";
   }
   
   /**
    * Need to call this method before displaying
    */
   function parse(){
      flush();
      ob_start();//Will g-zip output if browser supports this feature.
      $this->parse_template();
   }
   
   /**
    * Final output.  Could override this method with one calling
    * ob_get_contents() to dump output into a file instead.
    */
   function display(){
      $this->clean_up();
      echo $this->output;
      flush();
      //ob_end_flush();
   }
   
   /**
    * Main workhorse #1 - opens the template and calls replace_placeholders()
    */
   function parse_template(){
      $full_path = $this->template_dir.$this->template;
      $fp = @fopen($full_path, 'r');
      if (!$fp){
            if (@file_exists($full_path)){
                echo "Can't open template ".$full_path.".  Check permissions";
            } else {
					echo "Template ".$full_path." doesn't exist.";	
				}
            
      }
      $this->output = @fread ($fp, filesize($full_path));
      $this->replace_placeholders();
      @fclose($fp);
   }
   
   /**
    * Main workhorse #2: Actually does the content replacement in the template
    */
   function replace_placeholders(){
      foreach($this->placeholders as $placeholder => $replace){
         $search = $this->start_tag.$placeholder.$this->end_tag;
         $this->output = str_replace($search, $replace, $this->output);//perform substitution
      }
   }
   
   /**
    * Removes unused placeholders
    */
   function clean_up(){
      $expr = "$this->start_tag([a-zA-Z0-9_#]+)$this->end_tag";
      $this->output = ereg_replace($expr, "", $this->output);
   }
}
?>