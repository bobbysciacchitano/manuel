<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;

class JsonAPISerializer extends SerializerAbstract {

    /**
     *
     *
     * @param array $data
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function item(array $data, TransformerAbstract $transformer)
    {
        $resource = array(
            'id'         => $data['id'],
            'type'       => $transformer->getTypeKey(),
            'attributes' => $data
        );

        unset($resource['attributes']['id']);

        if ($transformer->getRelationships()) {
            $resource['relationships'] = array();

            foreach ($transformer->getRelationships() as $attribute) {
                $resource['relationships'][$attribute] = $this->createEmbeddedRelationship($data, $attribute);

                unset($resource['attributes'][$attribute]);
            }
        }

        return $resource;
    }

    /**
     *
     *
     * @param array $data
     * @param string $attribute
     * @return array
     */
    public function createEmbeddedRelationship($data, $attribute)
    {
        return array(
            'data' => array(
                'id'   => $data[$attribute],
                'type' => $attribute
            )
        );
    }

    /**
     *
     *
     * @param array $data
     * @param array $includes
     * @return array
     */
    public function payload(array $data, array $includes = null)
    {
        return array( 'data' => $data );
    }

}
