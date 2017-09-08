<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Price
 *
 * @package Zenwalker\CommerceML\Model
 * @property string performance
 * @property string cost
 * @property string currency
 * @property string unit
 * @property string rate
 */
class Price extends Model
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

    public function defaultProperties()
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
            if ($type = $this->owner->offerPackage->xpath("//c:ТипЦены[contains(c:Ид, '{$id}')]")) {
                $this->type = new Simple($this->owner, $type[0]);
            }
        }
        return $this->type;
    }

    public function init()
    {
        if ($this->xml && $this->xml->Цена) {
            foreach ($this->xml->Цена as $price) {
                $this->append(new Price($this->owner, $price));
            }
            $this->getType();
        }
        parent::init();
    }
}