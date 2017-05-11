<?php namespace Zenwalker\CommerceML\Model;

use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Product
 * @package Zenwalker\CommerceML\Model
 * @property string Штрихкод
 * @property \SimpleXMLElement БазоваяЕдиница
 */
class Product extends Model
{
    /**
     * @var Properties
     */
    protected $properties;
    /**
     * @var RequisiteCollection
     */
    protected $requisites;
    /**
     * @var SpecificationCollection
     */
    protected $specifications;

    /**
     * @var Price
     */
    protected $prices;
    /**
     * @var Group
     */
    protected $group;

    protected $images;

    public function __get($name)
    {
        if (!$result = parent::__get($name)) {
            if ($value = $this->getOffer()->{$name}) {
                return $value;
            }
        }
        return $result;
    }

    /**
     * @return Properties<Simple>
     */
    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new Properties($this->owner, $this->xml->ЗначенияСвойств);
        }
        return $this->properties;
    }

    public function getSpecifications()
    {
        if (!$this->specifications) {
            if (!$o = $this->getOffer()) {
                var_dump($this->getOffer());
                exit;
            }
            $this->specifications = new SpecificationCollection($this->owner, $xml->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    public function getPrices()
    {
        if (!$this->prices) {
            $this->prices = new Price($this->owner, $this->getOffer()->xml->Цены);
        }
        return $this->prices;
    }

    public function getRequisites()
    {
        if (!$this->requisites) {
            $this->requisites = new RequisiteCollection($this->owner, $this->xml->ЗначенияРеквизитов);
        }
        return $this->requisites;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        if (!$this->group) {
            foreach ($this->owner->classifier->getGroups() as $group) {
                if ($group->id == $this->Группы->Ид) {
                    $this->group = $group;
                } elseif ($child = $group->getChildById($this->Группы->Ид)) {
                    $this->group = $child;
                }
            }
        }
        return $this->group;
    }

    /**
     * @return null|Offer
     */
    public function getOffer()
    {
        return $this->owner->offerPackage->getOfferById($this->getClearId());
    }

    public function getImages()
    {
        if (!$this->images) {
            $this->images = new Image($this->owner, $this->xml->Картинка);
        }
        return $this->images;
    }

    /**
     * Class constructor.
     *
     * @param null $importXml
     * @param null $offersXml
     * @param null $owner
     *
     * @internal param $string [$importXml]
     * @internal param $string [$offersXml]
     */
//    public function __construct($importXml = null, $offersXml = null, $owner = null)
//    {
//        $this->name = '';
//        $this->quantity = 0;
//        $this->description = '';
//        $this->owner = $owner;
//        if (!is_null($importXml)) {
//            $this->loadImport($importXml);
//        }
//
//        if (!is_null($offersXml)) {
//            $this->loadOffers($offersXml);
//        }
//    }

    /**
     * Load primary data from import.xml.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
//    public function loadImport($xml)
//    {
//        $this->id = trim($xml->Ид);
//        $this->name = trim($xml->Наименование);
//        $this->description = trim($xml->Описание);
//        $this->sku = trim($xml->Артикул);
//        $this->unit = trim($xml->БазоваяЕдиница);
//
//        foreach ($xml->Картинка as $image) {
//            $this->images[(string)$image] = '';
//        }
//
//        if ($xml->Группы) {
//            $categoriesCollection = $this->owner ? $this->owner->getCollection('category') : [];
//            foreach ($xml->Группы->Ид as $id) {
//                if ($categoriesCollection && ($category = $categoriesCollection->get((string)$id))) {
//                    $this->categories[] = $category;
//                } else {
//                    $this->categories[] = (string)$id;
//                }
//            }
//        }
//
//        if ($xml->ЗначенияРеквизитов) {
//            foreach ($xml->ЗначенияРеквизитов->ЗначениеРеквизита as $requisite) {
//                $name = (string)$requisite->Наименование;
//                $value = (string)$requisite->Значение;
//                if ($name == 'ОписаниеФайла') {
//                    if (count($arr = explode('#', $value)) == 2 && isset($this->images[$arr[0]])) {
//                        $this->images[$arr[0]] = $arr[1];
//                    }
//                }
//                $this->requisites[] = ['name' => $name, 'value' => $value];
//            }
//        }
//
//        if ($xml->ЗначенияСвойств) {
//            $propertiesCollection = $this->owner ? $this->owner->getCollection('property') : [];
//            foreach ($xml->ЗначенияСвойств->ЗначенияСвойства as $prop) {
//                $id = (string)$prop->Ид;
//                $value = (string)$prop->Значение;
//                if ($value) {
//                    if ($propertiesCollection && ($property = $propertiesCollection->get($id))) {
//                        $property->values[] = $value;
//                        $this->properties[] = $property;
//                    } else {
//                        $this->properties[$id] = $value;
//                    }
//                }
//            }
//        }
//    }

    /**
     * Load primary data form offers.xml.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
//    public function loadOffers($xml)
//    {
//        if ($xml->Количество) {
//            $this->quantity = (float)$xml->Количество;
//        }
//
//        if ($xml->Цены) {
//            if (!$priceTypesCollection = $this->owner->getCollection('priceType')) {
//                $priceTypesCollection = [];
//            }
//            foreach ($xml->Цены->Цена as $price) {
//                $id = (string)$price->ИдТипаЦены;
//                $priceModel = new Price();
//                $priceModel->caption = (string)$price->Представление;
//                $priceModel->cost = (float)$price->ЦенаЗаЕдиницу;
//                $priceModel->currency = (string)$price->Валюта;
//                $priceModel->unit = (string)$price->Единица;
//                $priceModel->rate = (float)$price->Коэффициент;
//                $priceModel->type = $priceTypesCollection ? $priceTypesCollection->get($id) : $id;
//                $this->price[] = $priceModel;
//            }
//        }
//        if ($xml->ХарактеристикиТовара) {
//            foreach ($xml->ХарактеристикиТовара->ХарактеристикаТовара as $property) {
//                $this->характеристикиТовара[(string)$property->Наименование] = (string)$property->Значение;
//            }
//        }
//    }

    /**
     * Get price by type.
     *
     * @param string $type
     *
     * @return float
     */
//    public function getPrice($type)
//    {
//        foreach ($this->price as $price) {
//            if ($price['type'] == $type) {
//                return $price['value'];
//            }
//        }
//
//        return 0;
//    }
}
