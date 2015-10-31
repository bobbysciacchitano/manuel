<?php

require_once __DIR__ . '/../mocks/DummyTransformer.php';
require_once __DIR__ . '/../mocks/DummyEmbeddedTransformer.php';

class TransformerTest extends PHPUnit_Framework_TestCase {

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
    $transformer = new DummyTransformer;

    $this->assertEquals(array('simple_relationship'), $transformer->getRelationships());
  }

  public function testLinkedResources()
  {
    $transformer = new DummyTransformer;

    $this->assertEquals(array('simple_linked'), $transformer->getLinkedResources());
  }

  public function testEmbeddedResources()
  {
    $transformer = new DummyTransformer;

    $this->assertEquals(array('test'), $transformer->getEmbeddedResources());
  }

}
