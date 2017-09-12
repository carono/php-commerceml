<?php namespace Zenwalker\CommerceML\Model;

use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Product
 *
 * @package Zenwalker\CommerceML\Model
 * @property string Штрихкод
 * @property string Артикул
 * @property string Наименование
 *
 * @property \SimpleXMLElement БазоваяЕдиница
 * @property Image images
 * @property Offer offer
 * @property Group group
 * @property RequisiteCollection requisites
 * @property Price[] prices
 * @property PropertyCollection properties
 */
class Product extends Model
{
    /**
     * @var PropertyCollection
     */
    protected $properties;
    /**
     * @var RequisiteCollection
     */
    protected $requisites;
    /**
     * @var SpecificationCollection
     */
    protected $specifications;

    /**
     * @var Price
     */
    protected $prices;
    /**
     * @var Group
     */
    protected $group;

    protected $images;

    /**
     * @return PropertyCollection<Simple>
     */
    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->ЗначенияСвойств);
        }
        return $this->properties;
    }

    /**
     * @return SpecificationCollection
     */
    public function getSpecifications()
    {
        return $this->getOffer() ? $this->getOffer()->getSpecifications() : null;
    }

    /**
     * @return Price[]
     */
    public function getPrices()
    {
        return $this->getOffer() ? $this->getOffer()->getPrices() : [];
    }

    /**
     * @return RequisiteCollection
     */
    public function getRequisites()
    {
        if (!$this->requisites) {
            $this->requisites = new RequisiteCollection($this->owner, $this->xml->ЗначенияРеквизитов);
        }
        return $this->requisites;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        if (!$this->group) {
            foreach ($this->owner->classifier->getGroups() as $group) {
                if ($group->id == $this->Группы->Ид) {
                    $this->group = $group;
                } elseif ($child = $group->getChildById($this->Группы->Ид)) {
                    $this->group = $child;
                }
            }
        }
        return $this->group;
    }

    /**
     * @return null|Offer
     */
    public function getOffer()
    {
        return $this->owner->offerPackage->getOfferById($this->getClearId());
    }

    /**
     * @return Image
     */
    public function getImages()
    {
        if (!$this->images) {
            $this->images = new Image($this->owner, $this->xml->Картинка);
        }
        return $this->images;
    }
}
