<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

class OfferPackage extends Model
{
    /**
     * @var Offer[]
     */
    public $offers = [];

    public function loadXml()
    {
        return $this->owner->offersXml->ПакетПредложений;
    }

    /**
     * @return Offer[]
     */
    public function getOffers()
    {
        if (!$this->offers) {
            foreach ($this->xml->Предложения->Предложение as $offer) {
                $this->offers[] = new Offer($this->owner, $offer);
            }
        }
        return $this->offers;
    }

    /**
     * @param $id
     * @return null|Offer
     */
    public function getOfferById($id)
    {
        foreach ($this->getOffers() as $offer) {
            if ($offer->id == $id) {
                return $offer;
            }
        }
        return null;
    }
}