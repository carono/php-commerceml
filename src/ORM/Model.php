<?php namespace Zenwalker\CommerceML\ORM;

use Zenwalker\CommerceML\CommerceML;

/**
 * Class Model
 *
 * @package Zenwalker\CommerceML\ORM
 * @property string id
 * @property string name
 * @property string value
 */
abstract class Model extends \ArrayObject
{
    public function defaultProperties()
    {
        return [
            'Ид'           => 'id',
            'Наименование' => 'name',
            'Значение'     => 'value',
        ];
    }

    public function getClearId()
    {
        return explode('#', $this->id)[0];
    }

    public function getIdSuffix()
    {
        return array_slice(explode('#', (string)$this->id), 1)[0];
    }

    public function __construct(CommerceML $owner, \SimpleXMLElement $xml = null)
    {
        $this->owner = $owner;
        $this->xml = $xml ? $xml : $this->loadXml();
        $this->init();
        parent::__construct();
    }

    public function __get($name)
    {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return call_user_func([$this, $method]);
        }
        if ($this->xml) {
            $attributes = $this->xml;
            if (isset($attributes[$name])) {
                return (string)$attributes[$name];
            }
            if ($value = $this->xml->{$name}) {
                return $value;
            }
            if ($idx = array_search($name, $this->defaultProperties())) {
                return (string)$this->xml->{$idx};
            }
        }
        return null;
    }

    public function loadXml()
    {
        return null;
    }

    /**
     * @var CommerceML
     */
    public $owner;
    /**
     * @var \SimpleXMLElement
     */
    public $xml;

    public function init()
    {

    }
}
