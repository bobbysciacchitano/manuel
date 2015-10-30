<?php namespace Mocks;

class DummyTransformer extends TransformerAbstract {

  /**
   * @inheritdoc
   */
  protected $type = 'test';

  /**
   *
   *
   * @param array $data
   * @return array
   */
  public function transform($data)
  {
    return array(
      'id' => (int) 1,
      'value_1' => "value_1",
      'value_2' => "value_2"
    );
  }

}
