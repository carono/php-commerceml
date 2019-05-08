<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class Price
 *
 * @package Zenwalker\CommerceML\Model
 * @property string performance
 * @property string cost
 * @property string currency
 * @property string unit
 * @property string rate
 * @property Simple type
 */
class Price extends Simple
{
    protected $type;

    public function __get($name)
    {
        if ($result = parent::__get($name)) {
            if ($this->type && ($value = $this->type->{$name})) {
                return $value;
            }
        }
        return $result;
    }

    public function propertyAliases()
    {
        return [
            'Представление' => 'performance',
            'ИдТипаЦены' => 'id',
            'ЦенаЗаЕдиницу' => 'cost',
            'Валюта' => 'currency',
            'Единица' => 'unit',
            'Коэффициент' => 'rate',
        ];
    }

    public function getType()
    {
        if (!$this->type && ($id = $this->id)) {
            if ($type = $this->owner->offerPackage->xpath('//c:ТипЦены[c:Ид = :id]', ['id' => $id])) {
                $this->type = new Simple($this->owner, $type[0]);
            }
        }
        return $this->type;
    }

    public function init()
    {
        if ($this->xml && $this->xml->Цена) {
            foreach ($this->xml->Цена as $price) {
                $this->append(new self($this->owner, $price));
            }
            $this->getType();
        }
        parent::init();
    }
}