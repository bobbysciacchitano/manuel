<?php

use Manuel\Transformer\TransformerAbstract;
use Manuel\Resource\Item;

class DummyTransformer extends TransformerAbstract {

  /**
   * @inheritdoc
   */
  protected $type = 'test';

  /**
   * @inheritdoc
   */
  protected $relationships = [ 'simple_relationship' ];

  /**
   * @inheritdoc
   */
  protected $linkedResources = [ 'simple_linked' ];

  /**
   * @inheritdoc
   */
  protected $embeddedResources = [ 'test' ];

  /**
   *
   *
   * @param array $data
   * @return array
   */
  public function transform($data)
  {
    return array(
      'id' => (int) $data['id'],
      'value_1' => "value_1",
      'value_2' => "value_2"
    );
  }

  /**
   *
   * @param array $data
   * @return array
   */
  public function relationshipSimpleRelationship($data)
  {
    return 5;
  }

  /**
   *
   * @param array $data
   * @return string
   */
  public function linkedSimpleLinked($data)
  {
    return '/customer/1/testing';
  }

  /**
   *
   * @param array $data
   * @return string
   */
  public function embeddedTest($data)
  {
    return new Item(array('id' => 9, 'test' => 'test'), new DummyEmbeddedTransformer);
  }
}
