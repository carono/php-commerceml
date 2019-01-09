<?php

namespace Zenwalker\CommerceML\Tests;


class CommerceMLTest extends TestCase
{
    /**
     * @dataProvider xmlProvider
     * @param $values
     */
    public function testAddXmls($values): void
    {
        $this->cml->addXmls($values['import'], $values['offer'], $values['order']);
        $this->assertNotEmpty($this->cml->catalog->xml);
        $this->assertNotEmpty($this->cml->classifier->xml);
        $this->assertNotEmpty($this->cml->order->xml);
    }

    /**
     * @dataProvider xmlProvider
     * @param $values
     */
    public function testLoadImportXml($values): void
    {
        $this->cml->loadImportXml($values['import']);
        $this->assertNotEmpty($this->cml->catalog->xml);
    }

    /**
     * @dataProvider xmlProvider
     * @param $values
     */
    public function testLoadOffersXml($values): void
    {
        $this->cml->loadImportXml($values['offer']);
        $this->assertNotEmpty($this->cml->classifier->xml);
    }

    /**
     * @dataProvider xmlProvider
     * @param $values
     */
    public function testLoadOrdersXml($values): void
    {
        $this->cml->loadOrdersXml($values['order']);
        $this->assertNotEmpty($this->cml->order->xml);
    }
}
