<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Collections\PropertyCollection;

/**
 * Class Classifier
 *
 * @package Zenwalker\CommerceML\Model
 * @property PropertyCollection properties
 * @property Group[] groups
 */
class Classifier extends Simple
{
    /**
     * @var Group[]
     */
    protected $groups = [];
    /**
     * @var PropertyCollection
     */
    protected $properties;

    public function loadXml()
    {
        if ($this->owner->importXml && $this->owner->importXml->Классификатор) {
            return $this->owner->importXml->Классификатор;
        }

        return null;
    }

    public function getReferenceBook($id)
    {

        return $this->xpath("//c:Свойство[c:Ид = '{$id}']/c:ВариантыЗначений/c:Справочник");
    }

    public function getReferenceBookValueById($id)
    {
        if ($id) {
            $xpath = "//c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = '{$id}']";
            $type = $this->xpath($xpath);
            return $type ? $type[0] : null;
        }

        return null;
    }

    public function getGroupById($id)
    {
        foreach ($this->getGroups() as $group) {
            if ($group->id == $id) {
                return $group;
            }

            if ($child = $group->getChildById($id)) {
                return $child;
            }
        }
        return null;
    }

    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->Свойства);
        }
        return $this->properties;
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        if (empty($this->groups)) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->groups[] = new Group($this->owner, $group);
            }
        }
        return $this->groups;
    }
}