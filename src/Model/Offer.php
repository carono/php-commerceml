<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Collections\SpecificationCollection;

/**
 * Class Offer
 *
 * @package Zenwalker\CommerceML\Model
 * @property Price[] prices
 */
class Offer extends Simple
{
    /**
     * @var Price[]
     */
    protected $prices = [];
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