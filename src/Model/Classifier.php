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

    /**
     * @return null|\SimpleXMLElement
     */
    public function loadXml()
    {
        if ($this->owner->importXml && $this->owner->importXml->Классификатор) {
            return $this->owner->importXml->Классификатор;
        }

        return null;
    }

    /**
     * @param $id
     * @return \SimpleXMLElement[]
     */
    public function getReferenceBookById($id)
    {
        return $this->xpath('//c:Свойство[c:Ид = :id]/c:ВариантыЗначений/c:Справочник', ['id' => $id]);
    }

    /**
     * @param $id
     * @return null|\SimpleXMLElement
     */
    public function getReferenceBookValueById($id)
    {
        if ($id) {
            $xpath = '//c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = :id]';
            $type = $this->xpath($xpath, ['id' => $id]);
            return $type ? $type[0] : null;
        }

        return null;
    }

    /**
     * @param $id
     * @return null|Group
     */
    public function getGroupById($id)
    {
        foreach ($this->getGroups() as $group) {
            if ($group->id === $id) {
                return $group;
            }

            if ($child = $group->getChildById($id)) {
                return $child;
            }
        }
        return null;
    }

    /**
     * @return PropertyCollection
     */
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
        if (empty($this->groups) && isset($this->xml->Группы->Группа)) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->groups[] = new Group($this->owner, $group);
            }
        }
        return $this->groups;
    }
}
