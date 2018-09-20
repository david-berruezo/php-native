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
    use DOMXPath, DOMDocument, DOMText, DOMNode, DOMElement, DOMNodeList;

    class DOMOperation
    {

        /**
        * removes selected element(s)
        * 
        * @return DOM
        */
        public function remove()
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {
                if(isset($this->DOMNodeList))
                {

                    foreach($this->DOMNodeList as $node)
                    {
                        $node->parentNode->removeChild($node);
                    }

                }
            }

            return $this;

        }

        /**
        * appends string to element(s)
        * 
        * @param string $string
        * @return DOM
        */
        public function append($toAppend)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {

                $DOMToClone = $this->filterToDOM($toAppend);

                foreach($this->DOMNodeList as $node)
                {

                    $DOM = clone $DOMToClone;

                    /**
                    * @var DOMNode
                    */
                    $node->appendChild($DOM);

                }
            }

            return $this;

        }

        /**
        * prepends string to element(s)
        * 
        * @param string $string
        * @return DOM
        */
        public function prepend($toAppend)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {
                $DOMToClone = $this->filterToDOM($toAppend);

                foreach($this->DOMNodeList as $node)
                {
                    $DOM = clone $DOMToClone;
                    /**
                    * @var DOMNode
                    */
                    $node->insertBefore($DOM, $node->firstChild);

                }
            }

            return $this;

        }

        /**
        * set attribute to element or if the second argument
        * is empty the value of first argument named attribute will be returned
        * 
        * @param string $string
        * @return DOM | string
        */
        public function attr($name, $value = null)
        {

            if(! $this->isDOCSelected())
            {
                $this->saveInStack(__FUNCTION__, func_get_args());
                return $this;
            }

            if(! is_null($value))
            {

                foreach($this->DOMNodeList as $node)
                {

                    /**
                    * @var DOMElement
                    */
                    $node->setAttribute($name, $value);

                }
                return $this;
            }
            else
            {

                $return = '';

                foreach($this->DOMNodeList as $node)
                {

                    /**
                    * @var DOMElement
                    */
                    $return = $node->getAttribute($name);
                    break;
                }

                return $return;

            }




        }

        /**
        * removes an attribute
        * 
        * @param mixed $name
        * @return DOM
        */
        public function removeAttr($name)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {

                foreach($this->DOMNodeList as $node)
                {

                    /**
                    * @var DOMElement
                    */
                    $node->removeAttribute($name);

                }

            }

            return $this;

        }

        /**
        * assigns a property to the element(s)
        * 
        * @param string $property
        * @param string $value
        * @return DOM
        */
        public function css($property, $value)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {
                $property = trim($property);
                $value = rtrim(trim($value), ';');

                foreach($this->DOMNodeList as $node)
                {

                    if($node->hasAttribute('style'))
                    {
                        $change = array();
                        $styles = explode(';', $node->getAttribute('style'));
                        $done = false;

                        foreach($styles as $style)
                        {
                            if(! stristr($style, ':'))
                                continue;

                            $explodedStyle = explode(':', $style);
                            $styleProp = trim($explodedStyle[0]);
                            $styleVal = trim($explodedStyle[1]);

                            if($styleProp == $property)
                            {
                                $done = true;
                                $styleVal = $value;
                            }

                            $change[] = $styleProp . ': ' . $styleVal;

                        }
                        if(! $done)
                            $change[] = $property . ': ' . $value;

                        $change = implode('; ', $change) . ';';
                    }
                    else
                    {
                        $change = $property . ': ' . $value . ';';
                    }
                    /**
                    * @var DOMElement
                    */
                    $node->setAttribute('style', $change);

                }
            }

            return $this;

        }

        /**
        * Filters everything to DOM
        * 
        * @param mixed $toAssess
        * @return DOMNode
        */
        private function filterToDOM($toAssess)
        {

            if(is_string($toAssess))
                $DOM = new DOMText($toAssess);
            elseif($toAssess instanceof DOMNode)
                $DOM = $toAssess;
            else
                $DOM = $toAssess[0];

            return $DOM;

        }

        /**
        * changes inner html content
        * if empty passed returns html content
        * 
        * @param mixed $html
        * @return DOM | string
        */
        public function html($html = null)
        {

            if(! $this->isDOCSelected())
            {
                $this->saveInStack(__FUNCTION__, func_get_args());
                return $this;
            }

            if(is_null($html))
                foreach($this->DOMNodeList as $node)
                {

                    /**
                    * @var DOMElement
                    */
                    return $node->textContent;

            }
            else
            {
                function remove_children(&$node) {
                    while ($node->firstChild) {
                        while ($node->firstChild->firstChild) {
                            remove_children($node->firstChild);
                        }
                        $node->removeChild($node->firstChild);
                    }
                }

                foreach($this->DOMNodeList as $node)
                {
                    remove_children($node);
                    $node->appendChild(new DOMText($html));
                }
            }
            return $this;

        }

        /**
        * adds a class to element(s)
        * 
        * @param mixed $class
        * @return DOM
        */
        public function addClass($class)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {

                $class = trim($class);

                foreach($this->DOMNodeList as $node)
                {

                    $change = array($class);

                    if($node->hasAttribute('class'))
                    {

                        $classes = explode(' ', $node->getAttribute('class'));

                        foreach($classes as $nodeClass)
                        {
                            $nodeClass = trim($nodeClass);

                            if(! in_array($nodeClass, $change))
                                $change[] = $nodeClass;
                        }

                    }

                    /**
                    * @var DOMElement
                    */
                    $node->setAttribute('class', implode(' ', $change));

                }
            }

            return $this;

        }

        /**
        * removes a class to element(s)
        * 
        * @param mixed $class
        * @return DOM
        */
        public function removeClass($class)
        {

            if(! $this->isDOCSelected())
                $this->saveInStack(__FUNCTION__, func_get_args());
            else
            {

                $class = trim($class);

                foreach($this->DOMNodeList as $node)
                {

                    $change = array();

                    if($node->hasAttribute('class'))
                    {

                        $classes = explode(' ', $node->getAttribute('class'));

                        foreach($classes as $nodeClass)
                        {
                            $nodeClass = trim($nodeClass);

                            if(! in_array($nodeClass, $change) && $nodeClass != $class)
                                $change[] = $nodeClass;
                        }

                    }

                    /**
                    * @var DOMElement
                    */
                    $node->setAttribute('class', implode(' ', $change));

                }

            }
            return $this;

        }

        /**
        * it clones selected element
        * 
        * @return DOM
        */
        public function _clone()
        {
            if(! $this->isDOCSelected())
            {
                $this->saveInStack(__FUNCTION__, func_get_args());
                return $this;
            }

            return clone $this;

        }

    }
?>