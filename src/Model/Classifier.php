<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class Classifier extends Model
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
        if ($this->owner->importXml) {
            return $this->owner->importXml->Классификатор;
        }else{
            return null;
        }
    }

    public function getReferenceBookValueById($id)
    {
        if ($id) {
            return $this->xml->xpath("//Свойство/ВариантыЗначений/Справочник[contains(ИдЗначения,'{$id}')]")[0];
        } else {
            return null;
        }
    }

    public function getGroupById($id)
    {
        foreach ($this->getGroups() as $group) {
            if ($group->id == $id) {
                return $group;
            } elseif ($child = $group->getChildById($id)) {
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
        if (!$this->groups) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->groups[] = new Group($this->owner, $group);
            }
        }
        return $this->groups;
    }
}