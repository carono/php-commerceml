<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class ValueProperties
 *
 * @package Zenwalker\CommerceML\Model
 */
class PropertyCollection extends Simple
{
    /**
     * @param $id
     * @return Product|null
     */
    public function getById($id)
    {
        foreach ($this as $property) {
            if ($property->id == (string)$id) {
                return $property;
            }
        }
        return null;
    }

    public function init()
    {
        if ($this->xml && $this->xml->ЗначенияСвойства) {
            foreach ($this->xml->ЗначенияСвойства as $property) {
                $properties = $this->owner->classifier->getProperties();
                $object = clone $properties->getById($property->Ид);
                $object->productId = (string)$this->xpath('..')[0]->Ид;
                $object->init();
                $this->append($object);
            }
        }
        if ($this->xml && $this->xml->Свойство) {
            foreach ($this->xml->Свойство as $property) {
                $this->append(new Property($this->owner, $property));
            }
        }
        parent::init();
    }
}