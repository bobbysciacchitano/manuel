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

        foreach ($transformer->getRelationships() as $key => $attribute) {
            unset($resource['attributes'][$attribute]);
        }

        return $resource;
    }

    /**
     *
     *
     * @param array $data
     * @param array $includes
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function embedded(array $data, array $includes = null, TransformerAbstract $transformer)
    {
        $relationships = array();

        if (!$transformer->getRelationships()) {
            return array();
        }

        foreach ($transformer->getRelationships() as $key => $attribute) {
          if (array_key_exists($attribute, $data)) {
            $relationships[$attribute] = array(
                'id'   => $data[$attribute],
                'type' => $key ? $key : $attribute
            );
          }
        }

        return array('relationships' => $relationships);
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
