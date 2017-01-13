<?php namespace Zenwalker\CommerceML\Model;

use SimpleXMLElement;
use Zenwalker\CommerceML\ORM\Model;

class Property extends Model
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var array $values
     */
    public $values = array();

    /**
     * @param SimpleXMLElement|null $importXml
     *
     * @param null                  $owner
     */
    public function __construct($importXml = null, $owner = null)
    {
        $this->owner = $owner;
        if (!is_null($importXml)) {
            $this->loadImport($importXml);
        }
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return void
     */
    public function loadImport($xml)
    {
        $this->id = (string)$xml->Ид;
        $this->name = (string)$xml->Наименование;
        $valueType = (string)$xml->ТипЗначений;

        if ($valueType == 'Справочник' && $xml->ВариантыЗначений) {
            foreach ($xml->ВариантыЗначений->Справочник as $value) {
                $id = (string)$value->ИдЗначения;
                $this->values[$id] = (string)$value->Значение;
            }
        }
    }

    /**
     * @param string $valueId
     *
     * @return null|string
     */
    public function getValue($valueId)
    {
        if (isset($this->values[$valueId])) {
            return $this->values[$valueId];
        }
        return null;
    }
}