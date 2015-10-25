<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;

class JsonAPISerializer extends SerializerAbstract {

    /**
     * @inheritdoc
     */
    public function item(array $data, TransformerAbstract $transformer)
    {
        $resource = array(
            'id'         => $data['id'],
            'type'       => $transformer->getTypeKey(),
            'attributes' => $data
        );

        unset($resource['attributes']['id']);

        foreach ($transformer->getRelationships() as $relationship) {
            unset($resource['attributes'][$relationship]);
        }

        return $resource;
    }

    /**
     * @inheritdoc
     */
    public function embedded(array $resources, TransformerAbstract $transformer)
    {
        if (!$resources) {
            return array();
        }

        return ['relationships' => $resources];
    }

    /**
     * @inheritdoc
     */
    public function payload(array $data, array $includes = null)
    {
        return array( 'data' => $data );
    }

}
