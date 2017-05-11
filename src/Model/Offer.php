<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class Offer extends Model
{
    public function init()
    {
        foreach ($this->xml->xpath("../Предложение[contains(Ид,'{$this->id}#')]") as $specificationOffer) {
            $this->append(new Offer($this->owner, $specificationOffer));
        }
        if (!$this->count()) {
            $this->append($this);
        }
    }

    /**
     * @return Offer|null
     */
    public function getSpecificationOffer()
    {
        return $this->getIterator()->current();
    }
}