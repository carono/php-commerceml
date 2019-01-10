<?php


namespace Zenwalker\CommerceML\Collections;


use Zenwalker\CommerceML\Model\Image;
use Zenwalker\CommerceML\Model\Simple;

/**
 * Class Image
 *
 * @package Zenwalker\CommerceML\Model
 */
class ImageCollection extends Simple
{
    public function init()
    {
        if ($this->xml) {
            foreach ($this->xml as $image) {
                $this->append(new Image($this->owner, $image));
            }
        }
        parent::init();
    }
}