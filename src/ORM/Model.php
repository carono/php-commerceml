<?php namespace Zenwalker\CommerceML\ORM;

use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Simple;

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

    /**
     * @var CommerceML
     */
    public $owner;
    /**
     * @var \SimpleXMLElement
     */
    public $xml;

    /**
     * @return array
     */
    public function propertyAliases()
    {
        return [
            'Ид' => 'id',
            'Наименование' => 'name',
            'Значение' => 'value',
        ];
    }

    /**
     * @return string
     */
    public function getClearId()
    {
        return (string)explode('#', $this->id)[0];
    }

    /**
     * @return string
     */
    public function getIdSuffix()
    {
        return (string)\array_slice(explode('#', (string)$this->id), 1)[0];
    }

    /**
     * Model constructor.
     *
     * @param CommerceML $owner
     * @param \SimpleXMLElement|null $xml
     */
    public function __construct(CommerceML $owner, \SimpleXMLElement $xml = null)
    {
        $this->owner = $owner;
        $this->xml = $xml ?: $this->loadXml();
        $this->init();
        parent::__construct();
    }

    /**
     * @param $name
     * @return null|string
     */
    protected function getPropertyAlias($name)
    {
        $attributes = $this->xml;
        if ($idx = array_search($name, $this->propertyAliases())) {
            if (isset($attributes[$idx])) {
                return trim((string)$attributes[$idx]);
            }
            return trim((string)$this->xml->{$idx});
        }
        return null;
    }

    /**
     * @param $name
     * @return mixed|null|\SimpleXMLElement|string
     */
    public function __get($name)
    {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return \call_user_func([$this, $method]);
        }
        if ($this->xml) {
            $attributes = $this->xml;
            if (isset($attributes[$name])) {
                return trim((string)$attributes[$name]);
            }
            if ($value = $this->xml->{$name}) {
                return $value;
            }
            if (($value = $this->getPropertyAlias($name)) !== null) {
                return $value;
            }
        }
        return null;
    }

    public function __set($name, $value)
    {
    }

    public function __isset($name)
    {
    }

    public function loadXml()
    {
        $this->registerNamespace();
        return null;
    }

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
     * //c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = ':параметр']
     *
     * @param string $path
     * @param array $args - Аргументы задаём в бинд стиле ['параметр'=>'значение'] без двоеточия
     * @return \SimpleXMLElement[]
     */
    public function xpath($path, $args = [])
    {
        $this->registerNamespace();
        if (!$this->namespaceRegistered) {
            $path = str_replace('c:', '', $path);
        }
        if (!empty($args) && \is_array($args)) {
            foreach ($args as $ka => $kv) {
                $replace = (false !== strpos($kv, "'") ? ("concat('" . str_replace("'", "',\"'\",'", $kv) . "')") : "'" . $kv . "'");
                $path = str_replace(':' . $ka, $replace, $path);
            }
        }
        return $this->xml->xpath($path);
    }
}
