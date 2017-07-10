<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class Order extends Model
{
    /**
     * @var Document[]
     */
    public $documents = [];

    public function loadXml()
    {
        foreach ($this->owner->ordersXml->Документ as $document) {
            $this->documents[] = new Document($this->owner, $document);
        }
        return parent::loadXml();
    }
}