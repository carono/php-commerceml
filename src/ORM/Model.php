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
    private $namespaceRegistered = false;

    public function defaultProperties()
    {
        return [
            'Ид' => 'id',
            'Наименование' => 'name',
            'Значение' => 'value',
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
        $this->registerNamespace();
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
        $this->registerNamespace();
    }

    protected function registerNamespace()
    {
        if ($this->xml && !$this->namespaceRegistered && ($namespaces = $this->xml->getNamespaces())) {
            $this->namespaceRegistered = true;
            foreach ($namespaces as $namespace) {
                $this->xml->registerXPathNamespace('c', $namespace);
            }
        }
    }

    /**
     * Лучше использовать данный метод, вместо стандартного xpath у SimpleXMLElement,
     * т.к. есть проблемы с неймспейсами xmlns
     *
     * Для каждого элемента необходимо указывать наймспейс "c", например:
     * //c:Свойство/c:ВариантыЗначений/c:Справочник[contains(c:ИдЗначения,'{$id}')]
     *
     * @param string $path
     * @return \SimpleXMLElement[]
     */
    public function xpath($path)
    {
        $this->registerNamespace();
        if (!$this->namespaceRegistered) {
            $path = str_replace('c:', '', $path);
        }
        return $this->xml->xpath($path);
    }
}
