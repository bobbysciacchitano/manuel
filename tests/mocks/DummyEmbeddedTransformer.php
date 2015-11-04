<?php

use Manuel\Transformer\TransformerAbstract;
use Manuel\Resource\Item;

class DummyEmbeddedTransformer extends TransformerAbstract {

  /**
   * @inheritdoc
   */
  protected $type = 'test_embedded';

  /**
   *
   *
   * @param array $data
   * @return array
   */
  public function transform($data)
  {
    return array(
      'id'   => (int) $data['id'],
      'test' => "data_" . $data['id']
    );
  }

}
