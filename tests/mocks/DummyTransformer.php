<?php

use Manuel\Transformer\TransformerAbstract;

class DummyTransformer extends TransformerAbstract {

  /**
   * @inheritdoc
   */
  protected $type = 'test';

  /**
   * @inheritdoc
   */
  protected $relationships = [ 'simple' ];

  /**
   * @inheritdoc
   */
  protected $linkedResources = [ 'simple' ];

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
  public function relationshipSimple($data)
  {
    return 'testing';
  }

  /**
   *
   * @param array $data
   * @return string
   */
  public function linkedSimple($data)
  {
    return 'testing';
  }

}
