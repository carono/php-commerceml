<?php namespace Zenwalker\CommerceML;

use Zenwalker\CommerceML\Model\Category;
use Zenwalker\CommerceML\Model\CategoryCollection;
use Zenwalker\CommerceML\Model\PriceType;
use Zenwalker\CommerceML\Model\PriceTypeCollection;
use Zenwalker\CommerceML\Model\Product;
use Zenwalker\CommerceML\Model\ProductCollection;
use Zenwalker\CommerceML\Model\Property;
use Zenwalker\CommerceML\Model\PropertyCollection;
use Zenwalker\CommerceML\ORM\Collection;


class CommerceML
{

    /**
     * Data collections.
     *
     * @var array|Collection[]
     */
    protected $collections = [];

    /**
     * Class constructor.
     *
     * @return \Zenwalker\CommerceML\CommerceML
     */
    public function __construct()
    {
        $this->collections = [
            'category' => new CategoryCollection(),
            'product' => new ProductCollection(),
            'priceType' => new PriceTypeCollection(),
            'property' => new PropertyCollection()
        ];
    }

    /**
     * Add XML files.
     *
     * @param string|bool $importXml
     * @param string|bool $offersXml
     */
    public function addXmls($importXml = false, $offersXml = false)
    {

        if ($importXml) {
            $importXml = $this->loadXml($importXml);

            $this->parseCategories($importXml);
            $this->parseProperties($importXml);
        }

        if ($offersXml) {
            $offersXml = $this->loadXml($offersXml);

            $this->parsePriceTypes($offersXml);
        }

        $this->parseProducts($importXml, $offersXml);
    }

    /**
     * Parse products.
     *
     *
     * @param bool|\SimpleXMLElement $importXml
     * @param bool|\SimpleXMLElement $offersXml
     */
    public function parseProducts($importXml = false, $offersXml = false)
    {
        $buffer = [
            'products' => []
        ];

        if ($importXml) {
            if ($importXml->Каталог->Товары) {
                foreach ($importXml->Каталог->Товары->Товар as $product) {
                    $productId = (string)$product->Ид;
                    $buffer['products'][$productId]['import'] = $product;
                }
            }
        }

        if ($offersXml) {
            if ($offersXml->ПакетПредложений->Предложения) {
                foreach ($offersXml->ПакетПредложений->Предложения->Предложение as $offer) {
                    $productId = (string)$offer->Ид;
                    $buffer['products'][$productId]['offer'] = $offer;
                }
            }
        }

        foreach ($buffer['products'] as $item) {
            $import = isset($item['import']) ? $item['import'] : null;
            $offer = isset($item['offer']) ? $item['offer'] : null;

            $product = new Product($import, $offer, $this);
            $this->getCollection('product')->add($product);
        }
    }

    /**
     * Parse categories.
     *
     * @param \SimpleXMLElement $importXml
     * @param \SimpleXMLElement [$parent]
     *
     * @return void
     */
    public function parseCategories($importXml, $parent = null)
    {
        $xmlCategories = ($importXml->Классификатор->Группы) ? $importXml->Классификатор->Группы
            : $xmlCategories = $importXml;

        foreach ($xmlCategories->Группа as $xmlCategory) {
            $category = new Category($xmlCategory);
            $category->owner = $this;

            if (!is_null($parent)) {
                $parent->addChild($category);
            }

            $this->getCollection('category')->add($category);

            if ($xmlCategory->Группы) {
                $this->parseCategories($xmlCategory->Группы, $category);
            }
        }
    }

    /**
     * Parse price types.
     *
     * @param \SimpleXMLElement $offersXml
     *
     * @return void
     */
    public function parsePriceTypes($offersXml)
    {
        if ($offersXml->ПакетПредложений->ТипыЦен) {
            foreach ($offersXml->ПакетПредложений->ТипыЦен->ТипЦены as $xmlPriceType) {
                $priceType = new PriceType($xmlPriceType);
                $this->getCollection('priceType')->add($priceType);
            }
        }
    }

    /**
     * @param \SimpleXMLElement $importXml
     *
     * @return void
     */
    public function parseProperties($importXml)
    {
        if ($importXml->Классификатор->Свойства) {
            foreach ($importXml->Классификатор->Свойства->Свойство as $xmlProperty) {
                $property = new Property($xmlProperty, $this);
                $this->getCollection('property')->add($property);
            }
        }
    }

    /**
     * Get categories.
     *
     * @param array [$attach]
     *
     * @return array|Category[]
     */
    public function getCategories($attach = [])
    {
        $categories = $this->getCollection('category');

        foreach ($attach as $collection) {
            if (isset($this->collections[$collection])) {
                $categories->attach($this->collections[$collection]);
            }
        }

        return $categories->fetch();
    }

    /**
     * Get products.
     *
     * @param array $attach
     *
     * @return array|Product[]
     */
    public function getProducts($attach = [])
    {
        $products = $this->getCollection('product');

        foreach ($attach as $collection) {
            if (isset($this->collections[$collection])) {
                $products->attach($this->collections[$collection]);
            }
        }

        return $products->fetch();
    }

    /**
     * @param $name
     *
     * @return Collection
     */
    public function getCollection($name)
    {
        return $this->collections[$name];
    }


    /**
     * Load XML form file or string.
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement
     */
    private function loadXml($xml)
    {
        return is_file($xml) ? simplexml_load_file($xml) : simplexml_load_string($xml);
    }

}
