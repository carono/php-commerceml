<?php namespace Zenwalker\CommerceML;

use Zenwalker\CommerceML\Model\Catalog;
use Zenwalker\CommerceML\Model\Category;
use Zenwalker\CommerceML\Model\CategoryCollection;
use Zenwalker\CommerceML\Model\Classifier;
use Zenwalker\CommerceML\Model\Document;
use Zenwalker\CommerceML\Model\OfferPackage;
use Zenwalker\CommerceML\Model\Order;
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
        $this->importXml = $this->loadXml($importXml);
        $this->offersXml = $this->loadXml($offersXml);
        $this->ordersXml = $this->loadXml($ordersXml);

        $this->catalog = new Catalog($this);
        $this->classifier = new Classifier($this);
        $this->offerPackage = new OfferPackage($this);
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
            $content = file_get_contents($xml);
        } else {
            $content = $xml;
        }
        return simplexml_load_string(str_replace('xmlns=', 'ns=', $content));
    }
}
