<?php


namespace Zenwalker\CommerceML\Tests;


class ModelTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->cml->addXmls($this->import, $this->offer, $this->order);
    }
}