<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Model\Image;
use Zenwalker\CommerceML\Collections\ImageCollection;
use Zenwalker\CommerceML\Model\Offer;
use Zenwalker\CommerceML\Model\Price;
use Zenwalker\CommerceML\Model\Product;
use Zenwalker\CommerceML\Collections\RequisiteCollection;
use Zenwalker\CommerceML\Model\Property;
use Zenwalker\CommerceML\Model\Simple;
use Zenwalker\CommerceML\Tests\ModelTestCase;

class ProductTest extends ModelTestCase
{
    /**
     * @var Product
     */
    protected $product;

    public function setUp()
    {
        parent::setUp();
        $this->product = $this->cml->catalog->products[0];
    }

    public function testOffers()
    {
        $product = $this->product;
        $this->assertCount(2, $product->offers);
        $this->assertInstanceOf(Offer::class, $product->offers[0]);
    }

    public function testOfferPrice()
    {
        /**
         * @var Price $price
         */
        $prices = $this->product->offers[0]->prices;
        $this->assertCount(1, $prices);
        $price = $prices[0];
        $this->assertEquals('Розничная', $price->type->name);
        $this->assertEquals('1 719 RUB за пара', $price->performance);
    }

    public function testImages()
    {
        $images = $this->product->images;
        $this->assertCount(3, $images);
        $this->assertInstanceOf(ImageCollection::class, $images);
        $this->assertInstanceOf(Image::class, $images[0]);
        $this->assertEquals('import_files/9d/9da00149441011e19bb10015174048b8_0e01fd9e204611e8b2a794de807044d1.jpg', $images[0]->path);
        $this->assertEquals('Фото1', $images[0]->caption);
        $this->assertEmpty($images[1]->caption);

    }

    public function testRequisites()
    {
        $requisites = $this->product->requisites;
        $this->assertCount(4, $requisites);
        $this->assertInstanceOf(RequisiteCollection::class, $requisites);
        $this->assertInstanceOf(Simple::class, $requisites[0]);
        $this->assertEquals('Обувь', $requisites[0]->value);
    }

    public function testGroup()
    {
        $this->assertEquals('e5a4c309-a659-11dd-acee-0015e9b8c48d', $this->product->group->id);
        $this->assertEquals('453d6e3a-7233-11e0-8636-0011951d229d', $this->product->group->parent->id);
    }

    public function testProperties()
    {
        $this->assertEquals('Производитель', $this->product->properties[0]->name);
        $this->assertEquals('Обувной комбинат', $this->product->properties[0]->value);
        $this->assertInstanceOf(Property::class,$this->product->getProperties()->getById('bb14a4b8-6b17-11e0-9819-e0cb4ed5eed4'));
        $this->assertEmpty($this->product->getProperties()->getById('wrong-id'));
    }

    public function testPropertyValues()
    {
        $id = (string)$this->product->properties[0]->availableValues[5]->ИдЗначения;
        $this->assertEquals('444bbebb-6b18-11e0-9819-e0cb4ed5eed4', $id);
        $this->assertEquals('ООО Рога и копыта', $this->product->properties[3]->value);
    }
}