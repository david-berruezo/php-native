<?php
namespace clases;
use clases\Product;
class ProductBuilder
{
    protected $product = NULL;
    protected $configs = array();

    public function __construct($configs)
    {
        $this->product = new Product();
        $this->configs = $configs;
    }

    public function build()
    {
        $this->product->setSize($this->configs["size"]);
        $this->product->setType($this->configs["type"]);
        $this->product->setColor($this->configs["color"]);
    }

    public function getProduct()
    {
        return $this->product;
    }
}
?>