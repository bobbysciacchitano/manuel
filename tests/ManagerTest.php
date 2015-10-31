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
      'simple'  => 'testing',
      'links'   => array(
        'simple' => 'testing'
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
        'simple'  => 'testing',
        'links'   => array('simple' => 'testing')
      ),
      array(
        'id' => 2,
        'value_1' => 'value_1',
        'value_2' => 'value_2',
        'simple'  => 'testing',
        'links'   => array('simple' => 'testing')
      )
    );

    $this->assertEquals($expected, $payload);
  }

}
