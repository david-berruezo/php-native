<?php
namespace clases;
class CD{
    public $title         = "";
    public $band          = "";
    protected $_observers = array();
    public function __construct($title, $band)
    {
        $this->title = $title;
        $this->band  = $band;
    }

    public function attachObserver($type, $observer)
    {
        $this->_observers[$type][] = $observer;
    }

    public function notifyObserver($type)
    {
        if (isset($this->_observers[$type])) {
            foreach ($this->_observers[$type] as $observer)
            {
                $observer->update($this);
            }
        }
    }

    public function getTitle(){
        return $this->title;
    }
    public function buy()
    {
        //stub actions of buying
        $this->notifyObserver("purchased");
    }
}
?>