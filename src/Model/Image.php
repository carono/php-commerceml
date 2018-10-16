<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class Image
 *
 * @package Zenwalker\CommerceML\Model
 * @property string path
 * @property string caption
 */
class Image extends Simple
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

    public function getPath()
    {
        return (string)$this->xml;
    }

    public function getCaption()
    {
        if ($xml = $this->xpath("//c:ЗначениеРеквизита[contains(c:Значение, '{$this->path}#')]")) {
            return array_slice(explode('#', (string)$xml[0]->Значение), 1);
        }

        return null;
    }
}