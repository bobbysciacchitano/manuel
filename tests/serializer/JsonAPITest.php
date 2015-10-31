<?php

require_once __DIR__ . '/../mocks/DummyTransformer.php';

class JsonAPITest extends PHPUnit_Framework_TestCase {

  public function testCreateItem()
  {
    $serializer  = new \Manuel\Serializer\JsonAPISerializer;

    $transformer = new DummyTransformer;

    $data = array(
      'id' => 1,
      'alpha'  => 'gamma',
      'beta'   => 'theta',
    );

    $expected = array(
      'id'   => 1,
      'type' => 'test',
      'attributes' => array(
        'alpha' => 'gamma',
        'beta'  => 'theta'
      )
    );

    $this->assertEquals($expected, $serializer->item($data, $transformer));
  }

  public function testLinkRelationships()
  {
    $serializer = new \Manuel\Serializer\JsonAPISerializer;

    $expected = array(
      'links' => array(
        'related' => 'testing/test'
      )
    );

    $this->assertEquals($expected, $serializer->link('testing/test'));
  }

  public function testSimple()
  {
    $serializer = new \Manuel\Serializer\JsonAPISerializer;

    $expected = array(
      'data' => array(
        'id' => 1,
        'type' => 'test'
      )
    );

    $this->assertEquals($expected, $serializer->simple(1, 'test'));
  }

  public function testComplexRelationship()
  {
    $serializer = new \Manuel\Serializer\JsonAPISerializer;

    $expected = array(
      'data' => array(
        array('id' => 1, 'type' => 'test'),
        array('id' => 2, 'type' => 'test')
      )
    );

    $this->assertEquals($expected, $serializer->simple([1, 2], 'test'));
  }

  public function testEmbeddedRelationship()
  {
    $serializer  = new \Manuel\Serializer\JsonAPISerializer;

    $transformer = new DummyTransformer;

    $data = array(
      'id' => 1,
      'alpha'  => 'gamma',
      'beta'   => 'theta'
    );

    $expected = array(
      'id'   => 1,
      'type' => 'test',
      'attributes' => array(
        'alpha' => 'gamma',
        'beta'  => 'theta'
      )
    );

    $this->assertEquals($expected, $serializer->item($data, $transformer));
  }

  public function testPayloadCorrect()
  {
    $serializer = new \Manuel\Serializer\JsonAPISerializer;

    $data = array('test' => 'test');

    $this->assertEquals(array('data' => $data), $serializer->payload($data));
  }

}
