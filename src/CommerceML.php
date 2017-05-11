<?php namespace Zenwalker\CommerceML;

use Zenwalker\CommerceML\Model\Catalog;
use Zenwalker\CommerceML\Model\Category;
use Zenwalker\CommerceML\Model\CategoryCollection;
use Zenwalker\CommerceML\Model\Classifier;
use Zenwalker\CommerceML\Model\OfferPackage;
use Zenwalker\CommerceML\Model\PriceType;
use Zenwalker\CommerceML\Model\PriceTypeCollection;
use Zenwalker\CommerceML\Model\Product;
use Zenwalker\CommerceML\Model\ProductCollection;
use Zenwalker\CommerceML\Model\Property;
use Zenwalker\CommerceML\Model\PropertyCollection;
use Zenwalker\CommerceML\Model\Каталог;
use Zenwalker\CommerceML\ORM\Collection;

/**
 * Class CommerceML
 * @package Zenwalker\CommerceML
 * @property Product[] $products
 */
class CommerceML
{
    public $classCatalog;
    public $classClassifier;
    public $classOfferPackage;

    public $importXml;
    public $offersXml;

    /**
     * @var Catalog
     */
    public $catalog;
    /**
     * @var Classifier
     */
    public $classifier;

    /**
     * @var OfferPackage
     */
    public $offerPackage;

    /**
     * Add XML files.
     *
     * @param string|bool $importXml
     * @param string|bool $offersXml
     */
    public function addXmls($importXml = false, $offersXml = false)
    {
        $this->importXml = $this->loadXml($importXml);
        $this->offersXml = $this->loadXml($offersXml);

        $this->catalog = new Catalog($this);
        $this->classifier = new Classifier($this);
        $this->offerPackage = new OfferPackage($this);
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
