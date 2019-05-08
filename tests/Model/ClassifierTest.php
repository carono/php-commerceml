<?php


namespace Zenwalker\CommerceML\Tests\Model;


use Zenwalker\CommerceML\Tests\ModelTestCase;

class ClassifierTest extends ModelTestCase
{
    /**
     * @dataProvider referenceValueProvider
     */
    public function testGetReferenceBookValueById($id, $value)
    {
        $item = $this->cml->classifier->getReferenceBookValueById($id);
        $this->assertEquals($value, $item ? (string)$item->Значение : null);
    }

    /**
     * @dataProvider referenceProvider
     * @param $id
     * @param $value
     */
    public function testGetReferenceBookById($id, $value)
    {
        $items = $this->cml->classifier->getReferenceBookById($id);
        $this->assertEquals($value, isset($items[0]) ? (string)$items[0]->Значение : null);
    }

    /**
     * @dataProvider groupProvider
     */
    public function testGetGroupById($id, $name)
    {
        $group = $this->cml->classifier->getGroupById($id);
        $this->assertEquals($name, $group ? $group->name : null);
    }

    public function referenceProvider()
    {
        return [
            ['444bbe9e-6b18-11e0-9819-e0cb4ed5eed4', '115'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }

    public function referenceValueProvider()
    {
        return [
            ['444bbf2d-6b18-11e0-9819-e0cb4ed5eed4', '100'],
            ['444bbf75-6b18-11e0-9819-e0cb4ed5eed4', '1,5'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }

    public function groupProvider()
    {
        return [
            ['453d6e1a-7233-11e0-8636-0011951d229d', 'Бытовая техника'],
            ['f3257ce7-9c2f-11e1-a282-0011955bd175', 'Бытовая техника с учетом серий, гарантия 12 мес.'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }
}