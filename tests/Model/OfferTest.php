<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Model\Offer;
use Zenwalker\CommerceML\Tests\ModelTestCase;

class OfferTest extends ModelTestCase
{
    protected $product;
    /**
     * @var Offer[]
     */
    protected $offers;

    public function setUp()
    {
        parent::setUp();
        $this->product = $this->cml->catalog->products[0];
        $this->offers = $this->product->offers;
    }

    public function testSpecifications()
    {
        $offer = $this->offers[0];
        $specification = $offer->getSpecifications()[1];

        $this->assertEquals('14ed8b39-55bd-11d9-848a-00112f43529a', $specification->id);
        $this->assertEquals('Тип кожи', $specification->name);
        $this->assertEquals('натуральная кожа', $specification->value);
    }

    public function testSuffix()
    {
        $this->assertEquals('90c55447-d3a8-11e4-9423-e0cb4ed5eed4', $this->offers[0]->idSuffix);
    }

    public function testAttribute()
    {
        $this->assertEquals('false', $this->cml->offerPackage->containsOnlyChanges);
        $this->assertEquals('false', $this->cml->offerPackage->СодержитТолькоИзменения);
    }

    public function testStocksroom()
    {
        $stockroom = $this->cml->offerPackage->getStockrooms()[0];
        $offer = $this->offers[0];
        $this->assertEquals('b6112590-41ba-11dd-ac9d-0015e9b8c48d', $stockroom->id);
        $this->assertEquals('Магазин "Обувь"', $stockroom->name);

        $this->assertEquals('b6112590-41ba-11dd-ac9d-0015e9b8c48d', $offer->getStockrooms()[0]->id);
        $this->assertEquals('Магазин "Обувь"', $offer->getStockrooms()[0]->getPackageStockroom()->name);
        $this->assertEquals('20', $offer->getStockrooms()[0]->count);
    }
}