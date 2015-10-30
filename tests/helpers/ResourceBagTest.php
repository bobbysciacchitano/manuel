<?php

require_once __DIR__ . '../mocks/DummyTransformer.php';

class ResourceBagTest extends PHPUnit_Framework_TestCase {

  public function testCanCreateResrouceBag()
  {
    $data = array();

    $transformer = new \Mocks\DummyTransformer();
    $serializer  = new \Manuel\Serializer\JsonAPISerializer;

    $resourceBag = new ResourceBag($data, $transformer, $serializer);
  }

}
