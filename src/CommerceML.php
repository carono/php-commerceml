<?php namespace Zenwalker\CommerceML;

use Zenwalker\CommerceML\Model\Catalog;
use Zenwalker\CommerceML\Model\Classifier;
use Zenwalker\CommerceML\Model\OfferPackage;
use Zenwalker\CommerceML\Model\Order;
use Zenwalker\CommerceML\Model\Product;

/**
 * Class CommerceML
 *
 * @package Zenwalker\CommerceML
 * @property Product[] $products
 */
class CommerceML
{
    public $classCatalog;
    public $classClassifier;
    public $classOfferPackage;

    /**
     * @var \SimpleXMLElement
     */
    public $importXml;
    /**
     * @var \SimpleXMLElement
     */
    public $offersXml;
    /**
     * @var \SimpleXMLElement
     */
    public $ordersXml;
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
     * @var Order
     */
    public $order;

    /**
     * Add XML files.
     *
     * @param string|bool $importXml
     * @param string|bool $offersXml
     * @param bool $ordersXml
     */
    public function addXmls($importXml = false, $offersXml = false, $ordersXml = false)
    {
        $this->loadImportXml($importXml);
        $this->loadOffersXml($offersXml);
        $this->loadOrdersXml($ordersXml);
    }

    /**
     * @param $file
     */
    public function loadImportXml($file)
    {
        $this->importXml = $this->loadXml($file);
        $this->catalog = new Catalog($this);
        $this->classifier = new Classifier($this);
    }

    /**
     * @param $file
     */
    public function loadOffersXml($file)
    {
        $this->offersXml = $this->loadXml($file);
        $this->offerPackage = new OfferPackage($this);
    }

    /**
     * @param $file
     */
    public function loadOrdersXml($file)
    {
        $this->ordersXml = $this->loadXml($file);
        $this->order = new Order($this);
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
        /**
         * TODO костыль, вырезаем неймспейс, чтобы xpath работало без префиксов вероятно это делается другим способом, но я пока не нешел проще
         */
        if (is_file($xml)) {
            return simplexml_load_file($xml);
        } else {
            return simplexml_load_string($xml);
        }
    }
}
