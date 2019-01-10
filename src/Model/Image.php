<?php


namespace Zenwalker\CommerceML\Model;


class Image extends Simple
{

    /**
     * @return string
     */
    public function getPath()
    {
        return (string)$this->xml;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        if ($xml = $this->xpath("//c:ЗначениеРеквизита[contains(c:Значение, '{$this->path}#')]")) {
            return (string)\array_slice(explode('#', (string)$xml[0]->Значение), 1);
        }

        return '';
    }
}