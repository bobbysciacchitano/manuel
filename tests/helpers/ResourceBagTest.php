<?php

require_once __DIR__ . '/../mocks/DummyTransformer.php';
require_once __DIR__ . '/../mocks/DummySerializer.php';

class ResourceBagTest extends PHPUnit_Framework_TestCase {

  public $resourceBag;

  public function setUp()
  {
    $data = array();

    $transformer = new DummyTransformer;
    $serializer  = new DummySerializer;

    $this->resourceBag = new \Manuel\Helper\ResourceBag($data, $transformer, $serializer);
  }

  public function testCanLoadResources()
  {
    $this->assertTrue($this->resourceBag->containsRelationships());
  }

  public function testContainsSimple()
  {
    $this->assertTrue($this->resourceBag->containsSimple());
  }

  public function testFetchSimple()
  {
    $simple = $this->resourceBag->fetchSimple();

    $this->assertArrayHasKey('simple_item', $simple);
    $this->assertEquals(2, $simple['simple_item']);
  }

  public function testContainsLinks()
  {
    $this->assertTrue($this->resourceBag->containsLinks());
  }

  public function testFetchLinks()
  {
    $links = $this->resourceBag->fetchLinks();

    $this->assertArrayHasKey('simple_linked', $links);
    $this->assertEquals('/customer/1/testing', $links['simple_linked']);
  }

  public function testContainsEmbedded()
  {
    $this->assertTrue($this->resourceBag->containsEmbedded());
  }

  public function testFetchEmbedded()
  {
    $embedded = $this->resourceBag->fetchEmbedded();

    $this->assertArrayHasKey('test_item', $embedded);
    $this->assertEquals(5, $embedded['test_item']['id']);
  }

}
