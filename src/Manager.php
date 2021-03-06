<?php namespace Manuel;

use Manuel\Resource\ResourceAbstract;
use Manuel\Serializer\SerializerAbstract;

class Manager {

    /**
     * @var SerializerAbstract
     */
    protected $serializer;

    /**
     * Create a new manager for seriaializing and translating objects.
     *
     * @param SerializerAbstract $serializer
     */
    public function __construct(SerializerAbstract $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Translate a item into a resource and serialize the payload.
     *
     * @param ResourceAbstract $resource
     * @param string $resourceKey
     * @return array
     */
    public function translate(ResourceAbstract $resource, $resourceKey = null)
    {
        $resource = $resource->create($this->serializer);

        return $this->serializer->payload($resource, $resourceKey);
    }

}
