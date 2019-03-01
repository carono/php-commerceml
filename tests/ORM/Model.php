<?php


namespace Zenwalker\CommerceML\Tests\ORM;


use Zenwalker\CommerceML\Tests\ModelTestCase;

class Model extends ModelTestCase
{
    /**
     * Тестируем алиасы у атрибутов
     * Ид = id
     * Наименование = Name
     *
     * @see \Zenwalker\CommerceML\ORM\Model::propertyAliases
     */
    public function testAttributeAliases()
    {
        $product = $this->cml->catalog->products[0];
        $requisite = $product->requisites[0];

        $this->assertEquals($product->Ид, $product->id);
        $this->assertEquals($product->Наименование, $product->name);
        $this->assertEquals($requisite->Значение, $requisite->value);
    }
}