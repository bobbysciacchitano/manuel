<?php namespace Manuel\Resource;

use Manuel\Serializer\SerializerAbstract;
use Manuel\Transformer\TransformerAbstract;

abstract class ResourceAbstract {

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * @var string
     */
    protected $resourceKey;

    /**
     * Create a new resource object.
     *
     * @param mixed $data
     * @param TransformerAbstract $transformer
     * @param string $resourceKey
     */
    public function __construct($data, TransformerAbstract $transformer, $resourceKey = null)
    {
        $this->data = $data;

        $this->transformer = $transformer;

        $this->resourceKey = $resourceKey;
    }

    /**
     * Return the unserialized resource.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return the transformer the resource should use.
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Return the key for this resource.
     *
     * @return string
     */
    public function getResourceKey()
    {
        return $this->resourceKey;
    }

    /**
     * Format and serialize the response for the item.
     *
     * @param SerializerAbstract $serializer
     * @return array
     */
    abstract public function create(SerializerAbstract $serializer);

    /**
     * Retrieve resource IDs based on primary key value.
     *
     * @return mixed
     */
    abstract public function identifiers();

}
