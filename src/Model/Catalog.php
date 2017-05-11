<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * import.xml -> Каталог
 *
 * Class Catalog
 * @package Zenwalker\CommerceML\Model
 */
class Catalog extends Model
{
    /**
     * @var Product[]
     */
    protected $products = [];

    /**
     * @param $id
     * @return null|Product
     */
    public function getById($id)
    {
        foreach ($this->getProducts() as $product) {
            if ($product->id == $id) {
                return $product;
            }
        }
        return null;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        if (!$this->products) {
            foreach ($this->xml->Товары->Товар as $product) {
                $this->products[] = new Product($this->owner, $product);
            }
        }
        return $this->products;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function loadXml()
    {
        return $this->owner->importXml->Каталог;
    }
}