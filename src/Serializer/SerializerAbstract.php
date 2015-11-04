<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;
use Manuel\Helper\ResourceBag;

class SerializerAbstract {

    /**
     * @var string
     */
    protected $resourceKey;

    /**
     * @var array
     */
    protected $includes = array();

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
     * Serialize a embedded resource into a object.
     *
     * @param string $data
     * @param string $resourceKey
     * @return array
     */
    public function embedded($data, $resourceKey = null)
    {
        return $data;
    }

    /**
     * Serialize a included resource into a object.
     *
     * @param string $data
     * @param string $resourceKey
     * @return array
     */
    public function sideload($data, $resourceKey = null)
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
     * @return array
     */
    public function relationships(ResourceBag $resourceBag)
    {
        if (!$resourceBag->containsRelationships()) {
            return array();
        }

        $embedded = array_merge(
            $resourceBag->fetchSimple(),
            $resourceBag->fetchEmbedded(),
            $resourceBag->fetchIncludes()
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
     * @param string $resourceKey
     * @return array
     */
    public function payload(array $data, $resourceKey = null)
    {
        $payload = array();

        if ($resourceKey) {
          $payload[$resourceKey] = $data;
        } else {
          $payload = $data;
        }

        if ($this->includes) {
          foreach ($this->includes as $include) {
            $payload[] = $include;
          }
        }

        return $payload;
    }

}
