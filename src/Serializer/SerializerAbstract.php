<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;
use Manuel\Helper\ResourceBag;

class SerializerAbstract {

    /**
     * @return string
     */
    protected $resourceKey;

    /**
     * Serialize a base item into a resource.
     *
     * @param array $data
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function item(array $data, TransformerAbstract $transformer)
    {
        return $data;
    }

    /**
     * Serialize an array of items into a resource.
     *
     * @param array $data
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function collection(array $data, TransformerAbstract $transformer)
    {
        return $data;
    }

    /**
     * Serialize a link into a resource reference.
     *
     * @param string $data
     * @param string $resourceKey
     * @return array
     */
    public function link($data, $resourceKey = null)
    {
        return $data;
    }

    /**
     * Serialize a simple relationship.
     *
     * @param string $data
     * @param string $resourceKey
     * @return array
     */
    public function simple($data, $resourceKey = null)
    {
        return $data;
    }

    /**
     * Serialize embedded relationships that are stored in the resource bag.
     *
     * @param ResourceBag $resourceBag
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function embedded(ResourceBag $resourceBag, TransformerAbstract $transformer)
    {
        if (!$resourceBag->containsRelationships()) {
            return array();
        }

        $embedded = array_merge(
            $resourceBag->fetchSimple()
        );

        if ($resourceBag->containsLinks()) {
            $embedded['links'] = $resourceBag->fetchLinks();
        }

        return $embedded;
    }

    /**
     * Wrap base payload and sideloaded includes.
     *
     * @param array $data
     * @param array $includes
     * @param string $resourceKey
     * @return array
     */
    public function payload(array $data, $includes = array(), $resourceKey = null)
    {
        $payload = array();

        if ($resourceKey) {
          $payload[$resourceKey] = $data;
        } else {
          $payload = $data;
        }

        if ($includes) {
          foreach ($includes as $include) {
            $payload[] = $include;
          }
        }

        return $payload;
    }

}
