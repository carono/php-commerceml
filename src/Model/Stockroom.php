<?php

namespace Zenwalker\CommerceML\Model;

class Stockroom extends Simple
{
    private $_packageStockroom;

    public function getPackageStockroom()
    {
        if ($this->_packageStockroom) {
            return $this->_packageStockroom;
        }
        $id = $this->id;
        $xml = current($this->owner->offerPackage->xpath('//c:Склад[c:Ид = :id]', ['id' => $id]));
        return $this->_packageStockroom = new static($this->owner, $xml);
    }

    public function propertyAliases()
    {
        return array_merge(parent::propertyAliases(), [
            'ИдСклада' => 'id',
            'КоличествоНаСкладе' => 'count',
        ]);
    }
}