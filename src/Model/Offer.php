<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class Offer extends Model
{
    public $prices = [];
    public $specifications = [];

    /**
     * @return array|SpecificationCollection
     */
    public function getSpecifications()
    {
        if (!$this->specifications) {
            $this->specifications = new SpecificationCollection($this->owner, $this->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    /**
     * @return array|Price
     */
    public function getPrices()
    {
        if ($this->xml && !$this->prices) {
            $this->prices = new Price($this->owner, $this->xml->Цены);
        }
        return $this->prices;
    }
}