<?php

require_once __DIR__ . '/../mocks/DummyTransformer.php';
require_once __DIR__ . '/../mocks/DummyEmbeddedTransformer.php';

class TransformerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->transformer = new DummyTransformer();
        $this->transformer->resources(array());
    }

    public function testPrimaryKey()
    {
        $transformer = new DummyTransformer;

        $this->assertEquals('id', $transformer->getPrimaryKeyName());
    }

    public function testTypeKey()
    {
        $transformer = new DummyTransformer;

        $this->assertEquals('test', $transformer->getTypeKey());
    }

    public function testRelationships()
    {
        $actual = array_keys($this->transformer->getRelationships());

        $this->assertEquals(array('simple_item', 'simple_collection', 'relation_returns_null'), $actual);
    }

    public function testLinkedResources()
    {
        $actual = array_keys($this->transformer->getLinkedResources());

        $this->assertEquals(array('simple_linked'), $actual);
    }

    public function testEmbeddedResources()
    {
        $actual = array_keys($this->transformer->getEmbeddedResources());

        $this->assertEquals(array('test_item', 'test_collection'), $actual);
    }

    public function testSideloadedResources()
    {
        $actual = array_keys($this->transformer->getIncludedResources());

        $this->assertEquals(array('sideload_item', 'sideload_collection'), $actual);
    }

}
