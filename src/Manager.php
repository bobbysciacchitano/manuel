<?php namespace Manuel;

use Manuel\Resource\ResourceAbstract;
use Manuel\Serializer\SerializerAbstract;

class Manager {

    /**
     * @var SerializerAbstract
     */
    protected $serializer;

    /**
     *
     *
     * @param ResourceAbstract $resource
     * @param SerializerAbstract $serializer
     */
    public function __construct(SerializerAbstract $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     *
     *
     * @param ResourceAbstract $resource
     * @return array
     */
    public function translate(ResourceAbstract $resource)
    {
        $resource = $resource->create($this->serializer);

        return $this->serializer->payload($resource);
    }

}
