<?php namespace Manuel;

use Manuel\Resource\ResourceAbstract;
use Manuel\Serializer\SerializerAbstract;

class Manager {

    /**
     * @var ResourceAbstract
     */
    protected $resource;

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
    public function __construct(ResourceAbstract $resource, SerializerAbstract $serializer)
    {
        $this->resource   = $resource;

        $this->serializer = $serializer;
    }

    /**
     *
     *
     * @return array
     */
    public function translate()
    {
        $resource = $this->resource->create($this->serializer);

        return $this->serializer->payload($resource);
    }

}
