<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;
use Manuel\Helper\ResourceBag;

class SerializerAbstract {

    /**
     * @return string
     */
    protected $resourceKey;

    /**
     *
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
     *
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
     *
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
     *
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
     *
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
     *
     *
     * @param array $data
     * @param array $includes
     * @return array
     */
    public function payload(array $data, array $includes = array())
    {
        $payload = array($data);

        foreach ($includes as $include) {
            $payload[] = $include;
        }

        return $payload;
    }

}
