<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Model\Image;
use Zenwalker\CommerceML\Collections\ImageCollection;
use Zenwalker\CommerceML\Model\Offer;
use Zenwalker\CommerceML\Model\Product;
use Zenwalker\CommerceML\Collections\RequisiteCollection;
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

    public function testImages()
    {
        $images = $this->product->images;
        $this->assertCount(3, $images);
        $this->assertInstanceOf(ImageCollection::class, $images);
        $this->assertInstanceOf(Image::class, $images[0]);
        $this->assertEquals('import_files/9d/9da00149441011e19bb10015174048b8_0e01fd9e204611e8b2a794de807044d1.jpg', $images[0]->path);
    }

    public function testRequisites()
    {
        $requisites = $this->product->requisites;
        $this->assertCount(3, $requisites);
        $this->assertInstanceOf(RequisiteCollection::class, $requisites);
        $this->assertInstanceOf(Simple::class, $requisites[0]);
        $this->assertEquals('Обувь', $requisites[0]->value);
    }
}