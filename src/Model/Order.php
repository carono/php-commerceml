<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class Order
 *
 * @package Zenwalker\CommerceML\Model
 */
class Order extends Simple
{
    /**
     * @var Document[]
     */
    public $documents = [];

    public function loadXml()
    {
        if ($this->owner->ordersXml) {
            foreach ($this->owner->ordersXml->Документ as $document) {
                $this->documents[] = new Document($this->owner, $document);
            }
        }
        return $this->owner->ordersXml;
    }
}