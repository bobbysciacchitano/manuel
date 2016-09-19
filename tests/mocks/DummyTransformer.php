<?php

use Manuel\Transformer\TransformerAbstract;
use Manuel\Resource\Item;
use Manuel\Resource\Collection;

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
        'id'   => (int) $data['id'],
        'test' => 'data_' . $data['id']
      );
    }

    /**
     *
     *
     * @param $data
     */
    public function resources($data)
    {
        // Test Simple
        $this->addRelationship('simple_item', 2);

        $this->addRelationship('simple_collection', [3, 4]);

        $this->addRelationship('relation_returns_null', null);

        // Test Link
        $this->addLink('simple_linked', '/customer/1/testing');


        // Test Embedded
        $test = array('id' => 5);

        $this->addResource('test_item', new Item($test, new DummyEmbeddedTransformer));

        $test = array(array('id' => 6), array('id' => 7));

        $this->addResource('test_collection', new Collection($test, new DummyEmbeddedTransformer));


        // Test Included
        $test = array('id' => 8);

        $this->addResource('sideload_item', new Item($test, new DummyEmbeddedTransformer), true);

        $test = array(array('id' => 9), array('id' => 10));

        $this->addResource('sideload_collection', new Collection($test, new DummyEmbeddedTransformer), true);
    }

}
