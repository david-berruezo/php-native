<?php
namespace clases;
class BuyCDNotifyStreamObserver
{
    private $object;
    public function update(CD $cd)
    {
        $this->object = $cd;
        $activity = "The CD named {$cd->title} by ";
        $activity.= "{$cd->band} was just purchased.";
        $titulo = $cd->getTitle();
        echo "titulo es: ".$titulo."<br>";
        $titulo2 = $this->object->getTitle();
        echo "titulo es: ".$titulo2."<br>";
        var_dump($cd);
        var_dump($this->object);
        ActivityStream::addNewItem($activity);
    }
}
?>