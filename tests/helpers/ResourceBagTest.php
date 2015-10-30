<?php

require_once '../mocks/DummyTransformer.php';

class ResourceBagTest extends PHPUnit_Framework_TestCase

  testCanCreateResrouceBag()
  {
    $data = array();

    $transformer = new \Mocks\DummyTransformer();
    $serializer  = new \Manuel\Serializer\JsonAPISerializer;

    $resourceBag = new ResourceBag($data, $transformer, $serializer);
  }

}
