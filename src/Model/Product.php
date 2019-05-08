<?php namespace Zenwalker\CommerceML\Model;

use Zenwalker\CommerceML\Collections\ImageCollection;
use Zenwalker\CommerceML\Collections\PropertyCollection;
use Zenwalker\CommerceML\Collections\RequisiteCollection;
use Zenwalker\CommerceML\Collections\SpecificationCollection;

/**
 * Class Product
 *
 * @package Zenwalker\CommerceML\Model
 * @property \SimpleXMLElement Штрихкод
 * @property \SimpleXMLElement Артикул
 * @property \SimpleXMLElement Наименование
 * @property \SimpleXMLElement БазоваяЕдиница
 * @property \SimpleXMLElement Группы
 * @property ImageCollection images
 * @property Offer offer
 * @property Offer[] offers
 * @property Group group
 * @property RequisiteCollection requisites
 * @property Price[] prices
 * @property PropertyCollection properties
 */
class Product extends Simple
{
    /**
     * @var PropertyCollection Свойства продукта
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
     * @return PropertyCollection<Property>
     */
    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->ЗначенияСвойств);
        }
        return $this->properties;
    }

    /**
     * @return SpecificationCollection|null|array
     * @deprecated will removed in 0.3.0
     */
    public function getSpecifications()
    {
        return $this->getOffer() ? $this->getOffer()->getSpecifications() : null;
    }

    /**
     * @return Price[]
     * @deprecated will removed in 0.3.0
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
            if (!$this->Группы) {
                return null;
            }
            $groupId = (string)$this->Группы->Ид;
            $this->group = $this->owner->classifier->getGroupById($groupId);
        }
        return $this->group;
    }

    /**
     * @return null|Offer
     * @deprecated will removed in 0.3.0
     */
    public function getOffer()
    {
        return $this->owner->offerPackage->getOfferById($this->getClearId());
    }

    /**
     * @return Offer[]
     */
    public function getOffers()
    {
        return $this->owner->offerPackage->getOffersById($this->getClearId());
    }

    /**
     * @return ImageCollection
     */
    public function getImages()
    {
        if (!$this->images) {
            $this->images = new ImageCollection($this->owner, $this->xml->Картинка);
        }
        return $this->images;
    }
}
