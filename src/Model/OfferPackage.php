<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class OfferPackage
 *
 * @package Zenwalker\CommerceML\Model
 * @property Offer[] offers
 */
class OfferPackage extends Model
{
    /**
     * @var Offer[]
     */
    protected $offers = [];

    /**
     * @var Simple[] array
     */
    protected $priceTypes = [];

    public function loadXml()
    {
        if ($this->owner->offersXml) {
            return $this->owner->offersXml->ПакетПредложений;
        } else {
            return null;
        }
    }

    /**
     * @return Offer[]
     */
    public function getOffers()
    {
        if (!$this->offers && $this->xml && $this->xml->Предложения) {
            foreach ($this->xml->Предложения->Предложение as $offer) {
                $this->offers[] = new Offer($this->owner, $offer);
            }
        }
        return $this->offers;
    }

    /**
     * @return Simple[]
     */
    public function getPriceTypes()
    {
        if (!$this->priceTypes && $this->xml){
            foreach ($this->xpath('//c:ТипыЦен/c:ТипЦены') as $type){
                $this->priceTypes[] = new Simple($this->owner, $type);
            }
        }
        return $this->priceTypes;
    }

    /**
     * @param $id
     * @return null|Offer
     */
    public function getOfferById($id)
    {
        foreach ($this->getOffers() as $offer) {
            if ($offer->getClearId() == $id) {
                return $offer;
            }
        }
        return null;
    }
}