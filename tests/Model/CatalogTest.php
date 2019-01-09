<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Tests\ModelTestCase;

class CatalogTest extends ModelTestCase
{
    public function testGetParams(): void
    {
        $catalog = $this->cml->catalog;
        $this->assertEquals('07cfe53d-5145-4c4e-a81c-899be39cc5bd', $catalog->id);
        $this->assertEquals('Каталог товаров 07CFE53D', $catalog->name);
    }

    public function testGetProductById(): void
    {
        $product = $this->cml->catalog->getById('bd72d913-55bc-11d9-848a-00112f43529a');
        $notFound = $this->cml->catalog->getById('1');
        $this->assertEquals('Ботинки женские демисезонные', $product->name);
        $this->assertEmpty($notFound);
    }

    public function testGetProductByXml(): void
    {
        $product = $this->cml->catalog->Товары[0];
        $this->assertEquals('bd72d910-55bc-11d9-848a-00112f43529a', (string)$product->Товар->Ид);
    }
}