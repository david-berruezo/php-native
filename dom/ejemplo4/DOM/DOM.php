<?php
    /**
    *
    * FSS Framework
    *
    * @package : FSS Framework
    * @author : Mohamad Mohebifar
    * @copyright : Copyright (c) 2012, Mohamad Mohebifar
    * @link : http://www.mohebifar.ir
    * @since : Version 1.0
    */
    namespace DOM;
    use CssSelector\CssSelector;
    use DOMXPath, DOMDocument, DOMText;

    class DOM extends DOMOperation
    {

        protected static $doc = null;
        public $DOMNodeList = null, $selector = null;
        protected static $stack = array();

        /**
        * select DOM element(s) using CSS Selector
        * 
        * @param string $selector
        * @return DOM
        */
        final protected function __construct($selector)
        {

            $this->DOMNodeList = $this->CssSelectorToDOM($selector);
            $this->selector = $selector;

            return $this;

        }

        /**
        * select DOM element(s) using CSS Selector
        * 
        * @param string $selector
        * @return DOM
        */
        final public static function select($selector)
        {

            $instance = new static($selector);
            return $instance;

        }

        /**
        * this function prepares HTML to use by this library
        * 
        * @param string $HTML
        */
        public static function createDocFromHTML($HTML)
        {

            self::$doc = new DOMDocument('1.0', 'utf-8');
            $HTML = mb_convert_encoding($HTML, 'HTML-ENTITIES', 'UTF-8');

            @self::$doc->loadHTML($HTML);

        }

        /**
        * returns HTML
        * 
        * @return string HTML
        */
        public static function getHTML()
        {
            self::$doc->normalize();
            self::$doc->formatOutput = true;
            $HTML = self::$doc->saveHTML();
            $HTML = mb_convert_encoding($HTML, 'UTF-8', 'HTML-ENTITIES');
            return $HTML;
        }

        public static function getDOMDocument()
        {
            return self::$doc;
        }

        /**
        * this function gives css selector and returns DOMNodeList
        * 
        * @param string $selector
        * @return \DOMNodeList
        */
        private function CssSelectorToDOM($selector)
        {

            if(! $this->isDOCSelected())
                return false;

            $XPath = CssSelector::toXPath($selector);
            $XPathObject = new DOMXPath(self::$doc);
            $context = self::$doc->documentElement;

            return $XPathObject->query($XPath, $context);

        }

        /**
        * this function returns true if DOM is selected
        * 
        * @return bool
        */
        protected function isDOMSelected()
        {
            return (isset($this->selector));
        }

        /**
        * this function returns true if DOM is selected
        * 
        * @return bool
        */
        protected function isDOCSelected()
        {
            return (isset(self::$doc));
        }

        public function dumpStack()
        {
            var_dump(self::$stack);
        }

        /**
        * executes all the actions requested
        * 
        * @return void
        */
        public static function callStack()
        {

            foreach(self::$stack as $selector => $stack)
            {
                $instance = new static($selector);

                foreach($stack as $stackAction)
                {
                    call_user_func_array(array($instance, $stackAction['action']), $stackAction['args']);
                }
            }

        }

        /**
        * saves operations in one stack
        * 
        * @param mixed $selector
        * @param mixed $action
        * @param mixed $args
        * @return void
        */
        protected function saveInStack($action, $args)
        {
            self::$stack[$this->selector][] = array('action' => $action, 'args' => $args);
        }

    }
?>