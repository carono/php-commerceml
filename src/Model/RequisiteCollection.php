<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class ValueProperties
 *
 * @package Zenwalker\CommerceML\Model
 */
class RequisiteCollection extends Simple
{
    public function init()
    {
        if (isset($this->xml->ЗначениеРеквизита)) {
            foreach ($this->xml->ЗначениеРеквизита as $requisite) {
                $this->append(new Simple($this->owner, $requisite));
            }
        }
        parent::init();
    }

}