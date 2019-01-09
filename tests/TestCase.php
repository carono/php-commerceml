<?php


namespace Zenwalker\CommerceML\Tests;


use Zenwalker\CommerceML\CommerceML;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $import = __DIR__ . '/xml/import.xml';
    protected $offer = __DIR__ . '/xml/offers.xml';
    protected $order = __DIR__ . '/xml/orders.xml';
    protected $classifier = __DIR__ . '/xml/classifier.xml';
    protected $importWoClassifier = __DIR__ . '/xml/import_wo_classifier.xml';

    /**
     * @var CommerceML
     */
    protected $cml;

    public function setUp()
    {
        $this->cml = new CommerceML();
    }

    protected function tearDown()
    {
        $this->cml = null;
    }

    /**
     * @return array
     */
    public function xmlProvider()
    {
        return [
            [
                [
                    'import' => $this->import,
                    'offer' => $this->offer,
                    'order' => $this->order,
                    'classifier' => $this->classifier,
                    'importWoClassifier' => $this->importWoClassifier,
                ],
            ],
            [
                [
                    'import' => file_get_contents($this->import),
                    'offer' => file_get_contents($this->offer),
                    'order' => file_get_contents($this->order),
                    'classifier' => file_get_contents($this->classifier),
                    'importWoClassifier' => file_get_contents($this->importWoClassifier),
                ],
            ],
        ];
    }
}