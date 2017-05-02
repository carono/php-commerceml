<?php namespace Zenwalker\CommerceML\Model;

use Zenwalker\CommerceML\ORM\Model;

class Product extends Model
{
    public $характеристикиТовара = [];
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $sku
     */
    public $sku;

    /**
     * @var string $unit
     */
    public $unit;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var int $quantity
     */
    public $quantity;

    /**
     * @var array $price
     */
    public $price = [];

    /**
     * @var array
     */
    public $images = [];
    /**
     * @var array $categories
     */
    public $categories = [];

    /**
     * @var array $requisites
     */
    public $requisites = [];

    /**
     * @var array $properties
     */
    public $properties = [];

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
    public function __construct($importXml = null, $offersXml = null, $owner = null)
    {
        $this->name = '';
        $this->quantity = 0;
        $this->description = '';
        $this->owner = $owner;
        if (!is_null($importXml)) {
            $this->loadImport($importXml);
        }

        if (!is_null($offersXml)) {
            $this->loadOffers($offersXml);
        }
    }

    /**
     * Load primary data from import.xml.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function loadImport($xml)
    {
        $this->id = trim($xml->Ид);
        $this->name = trim($xml->Наименование);
        $this->description = trim($xml->Описание);
        $this->sku = trim($xml->Артикул);
        $this->unit = trim($xml->БазоваяЕдиница);

        foreach ($xml->Картинка as $image) {
            $this->images[(string)$image] = '';
        }

        if ($xml->Группы) {
            $categoriesCollection = $this->owner ? $this->owner->getCollection('category') : [];
            foreach ($xml->Группы->Ид as $id) {
                if ($categoriesCollection && ($category = $categoriesCollection->get((string)$id))) {
                    $this->categories[] = $category;
                } else {
                    $this->categories[] = (string)$id;
                }
            }
        }

        if ($xml->ЗначенияРеквизитов) {
            foreach ($xml->ЗначенияРеквизитов->ЗначениеРеквизита as $requisite) {
                $name = (string)$requisite->Наименование;
                $value = (string)$requisite->Значение;
                if ($name == 'ОписаниеФайла') {
                    if (count($arr = explode('#', $value)) == 2 && isset($this->images[$arr[0]])) {
                        $this->images[$arr[0]] = $arr[1];
                    }
                }
                $this->requisites[] = ['name' => $name, 'value' => $value];
            }
        }

        if ($xml->ЗначенияСвойств) {
            $propertiesCollection = $this->owner ? $this->owner->getCollection('property') : [];
            foreach ($xml->ЗначенияСвойств->ЗначенияСвойства as $prop) {
                $id = (string)$prop->Ид;
                $value = (string)$prop->Значение;
                if ($value) {
                    if ($propertiesCollection && ($property = $propertiesCollection->get($id))) {
                        $property->values[] = $value;
                        $this->properties[] = $property;
                    } else {
                        $this->properties[$id] = $value;
                    }
                }
            }
        }
    }

    /**
     * Load primary data form offers.xml.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function loadOffers($xml)
    {
        if ($xml->Количество) {
            $this->quantity = (float)$xml->Количество;
        }

        if ($xml->Цены) {
            if (!$priceTypesCollection = $this->owner->getCollection('priceType')) {
                $priceTypesCollection = [];
            }
            foreach ($xml->Цены->Цена as $price) {
                $id = (string)$price->ИдТипаЦены;
                $priceModel = new Price();
                $priceModel->caption = (string)$price->Представление;
                $priceModel->cost = (float)$price->ЦенаЗаЕдиницу;
                $priceModel->currency = (string)$price->Валюта;
                $priceModel->unit = (string)$price->Единица;
                $priceModel->rate = (float)$price->Коэффициент;
                $priceModel->type = $priceTypesCollection ? $priceTypesCollection->get($id) : $id;
                $this->price[] = $priceModel;
            }
        }
        if ($xml->ХарактеристикиТовара) {
            foreach ($xml->ХарактеристикиТовара->ХарактеристикаТовара as $property) {
                $this->характеристикиТовара[(string)$property->Наименование] = (string)$property->Значение;
            }
        }
    }

    /**
     * Get price by type.
     *
     * @param string $type
     *
     * @return float
     */
    public function getPrice($type)
    {
        foreach ($this->price as $price) {
            if ($price['type'] == $type) {
                return $price['value'];
            }
        }

        return 0;
    }
}
