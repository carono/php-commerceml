<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class ValueProperties
 *
 * @package Zenwalker\CommerceML\Model
 */
class RequisiteCollection extends Model
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