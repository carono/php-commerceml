<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Order
 *
 * @package Zenwalker\CommerceML\Model
 */
class Order extends Model
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
        return parent::loadXml();
    }
}