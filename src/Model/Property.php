<?php namespace Zenwalker\CommerceML\Model;

use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Property
 *
 * @package Zenwalker\CommerceML\Model
 */
class Property extends Model
{
    public $productId;
    protected $_value;

    /**
     * @return \SimpleXMLElement[]
     */
    public function getAvailableValues()
    {
        return $this->owner->classifier->getReferenceBook($this->id);
    }

    /**
     * @return Simple|null
     */
    public function getValueModel()
    {
        if ($this->productId && !$this->_value) {
            $product = $this->owner->catalog->getById($this->productId);
            $xpath = "ЗначенияСвойств/ЗначенияСвойства[contains(Ид,'{$this->id}')]";
            $valueXml = $product->xml->xpath($xpath)[0];
            $value = $this->_value = (string)$valueXml->Значение;
            if ($property = $this->owner->classifier->getReferenceBookValueById($value)) {
                $this->_value = new Simple($this->owner, $property);
            } else {
                $this->_value = new Simple($this->owner, $valueXml);
            }
        }
        return $this->_value;
    }

    public function getValue()
    {
        return $this->getValueModel() ? (string)$this->getValueModel()->value : null;
    }
}