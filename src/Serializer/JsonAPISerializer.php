<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;
use Manuel\Helper\ResourceBag;

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
    public function link($data, $resourceKey = null)
    {
        return array('links' => array('related' => $data));
    }

    /**
     * @inheritdoc
     */
    public function simple($data, $resourceKey = null)
    {
        if (is_array($data)) {
            $resources = array();

            foreach ($data as $resource) {
                $resources[] = array('id' => $resource, 'type' => $resourceKey);
            }

            return array('data' => $resources);
        } else {
            return array('data' => array('id' => $data, 'type' => $resourceKey));
        }
    }

    /**
     * Embed relationships in the correct format.
     *
     * @param ResourceBag $resourceBag
     * @return array
     */
    public function embedded(ResourceBag $resourceBag)
    {
        if (!$resourceBag->containsRelationships()) {
            return array();
        }

        return array('relationships' => array_merge(
            $resourceBag->fetchSimple(),
            $resourceBag->fetchLinks()
        ));
    }

    /**
     * @inheritdoc
     */
    public function payload(array $data, $includes = array(), $resourceKey = null)
    {
        return array('data' => $data);
    }

}
