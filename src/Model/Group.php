<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class Group extends Model
{
    /**
     * @var Group[]
     */
    protected $children = [];

    /**
     * @var Group
     */
    protected $parent;

    /**
     * @return Group[]
     */
    public function getChildren()
    {
        if (!$this->children && $this->xml->Группы) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->children[] = new Group($this->owner, $group);
            }
        }
        return $this->children;
    }

    /**
     * @return Group
     */
    public function getParent()
    {
        if (!$this->parent) {
            $parent = $this->xml->xpath("../..")[0];
            if ($parent->getName() == 'Группа') {
                $this->parent = new Group($this->owner, $parent);
            }
        }
        return $this->parent;
    }

    /**
     * @param $id
     * @return null|Group
     */
    public function getChildById($id)
    {
        foreach ($this->getChildren() as $child) {
            if ($child->id == $id) {
                return $child;
            } elseif ($subChild = $child->getChildById($id)) {
                return $subChild;
            }
        }
        return null;
    }
}