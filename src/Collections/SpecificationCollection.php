<?php


namespace Zenwalker\CommerceML\Collections;


use Zenwalker\CommerceML\Model\Simple;

/**
 * Class SpecificationCollection
 *
 * @package Zenwalker\CommerceML\Model
 */
class SpecificationCollection extends Simple
{
    public function init()
    {
        if (isset($this->xml->ХарактеристикаТовара)) {
            foreach ($this->xml->ХарактеристикаТовара as $specification) {
                $this->append(new Simple($this->owner, $specification));
            }
        }
        parent::init();
    }
}