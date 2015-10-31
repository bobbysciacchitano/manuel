<?php

require_once __DIR__ . '/mocks/DummyTransformer.php';
require_once __DIR__ . '/mocks/DummySerializer.php';

class ManagerTest extends PHPUnit_Framework_TestCase {

  public function testCanSerializeItem()
  {
    $manager = new \Manuel\Manager(new DummySerializer);

    $data = array(
      'id'   => 1,
      'test' => 'one'
    );

    $payload = $manager->translate(new \Manuel\Resource\Item($data, new DummyTransformer));

    $expected = array(
      'id' => 1,
      'value_1' => 'value_1',
      'value_2' => 'value_2',
      'simple_relationship' => 5,
      'test'    => array('id' => 9, 'value_1' => 'value_1', 'value_2' => 'value_2'),
      'links'   => array(
        'simple_linked' => '/customer/1/testing'
      )
    );

    $this->assertEquals($expected, $payload);
  }

  public function testCanSerializeCollection()
  {
    $manager = new \Manuel\Manager(new DummySerializer);

    $data = array(
      array('id' => 1, 'test' => 'one'),
      array('id' => 2, 'test' => 'two')
    );

    $payload = $manager->translate(new \Manuel\Resource\Collection($data, new DummyTransformer));

    $expected = array(
      array(
        'id' => 1,
        'value_1' => 'value_1',
        'value_2' => 'value_2',
        'simple_relationship' => 5,
        'test'    => array('id' => 9, 'value_1' => 'value_1', 'value_2' => 'value_2'),
        'links'   => array('simple_linked' => '/customer/1/testing')
      ),
      array(
        'id' => 2,
        'value_1' => 'value_1',
        'value_2' => 'value_2',
        'simple_relationship' => 5,
        'test'    => array('id' => 9, 'value_1' => 'value_1', 'value_2' => 'value_2'),
        'links'   => array('simple_linked' => '/customer/1/testing'),
      )
    );

    $this->assertEquals($expected, $payload);
  }

  public function testJsonAPICreate()
  {
    $manager = new \Manuel\Manager(new \Manuel\Serializer\JsonAPISerializer);

    $data = array('id' => 1, 'test' => 'one');

    $payload = $manager->translate(new \Manuel\Resource\Item($data, new DummyTransformer));

    $expected = array(
      'data' => array(
        'id' => 1,
        'type' => 'test',
        'attributes' => array(
          'value_1' => 'value_1',
          'value_2' => 'value_2'
        ),
        'relationships' => array(
          'simple_relationship' => array(
            'data' => array(
              'id' => 5,
              'type' => 'simple_relationship'
            )
          ),
          'test' => array(
            'data' => array(
              'id' => 9,
              'type' => 'test_embedded',
              'attributes' => array(
                'value_1' => 'value_1',
                'value_2' => 'value_2'
              )
            )
          ),
          'simple_linked' => array(
            'links' => array(
              'related' => '/customer/1/testing'
            )
          )
        )
      )
    );

    $this->assertEquals($expected, $payload);
  }

}
