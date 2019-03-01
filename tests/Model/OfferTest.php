<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Tests\ModelTestCase;

class OfferTest extends ModelTestCase
{
    protected $product;
    protected $offers;

    public function setUp()
    {
        parent::setUp();
        $this->product = $this->cml->catalog->products[0];
        $this->offers = $this->product->offers;
    }

    public function testSuffix()
    {
        $this->assertEquals('90c55447-d3a8-11e4-9423-e0cb4ed5eed4', $this->offers[0]->idSuffix);
    }
}