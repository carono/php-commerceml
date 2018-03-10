<?php

namespace Zenwalker\CommerceML;


class CommerceMLTest extends \PHPUnit\Framework\TestCase
{
    private $import = __DIR__ . '/xml/import.xml';
    private $offer = __DIR__ . '/xml/offers.xml';
    private $order = __DIR__ . '/xml/orders.xml';
    /**
     * @var CommerceML
     */
    private $cml;


    private function init()
    {
        $this->cml = new CommerceML();
    }

    public function testAddXmls()
    {
        $this->init();
        $this->cml->addXmls($this->import, $this->offer, $this->order);
        $this->assertNotEmpty($this->cml->catalog->xml);
        $this->assertNotEmpty($this->cml->classifier->xml);
        $this->assertNotEmpty($this->cml->order->xml);
    }

    public function testLoadImportXml()
    {
        $this->init();
        $this->cml->loadImportXml($this->import);
        $this->assertNotEmpty($this->cml->catalog->xml);
    }

    public function testLoadOffersXml()
    {
        $this->init();
        $this->cml->loadImportXml($this->offer);
        $this->assertNotEmpty($this->cml->classifier->xml);
    }

    public function testLoadOrdersXml()
    {
        $this->init();
        $this->cml->loadOrdersXml($this->order);
        $this->assertNotEmpty($this->cml->order->xml);
    }
}
