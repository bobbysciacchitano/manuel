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
     *
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
     *
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     *
     *
     * @return string
     */
    public function getResourceKey()
    {
        return $this->resourceKey;
    }

    /**
     *
     *
     * @param SerializerAbstract $serializer
     * @return array
     */
    public function create(SerializerAbstract $serializer)
    {
        $transformed = $serializer->item($this->transformer->transform($this->getData()), $this->transformer);

        return array_merge($transformed, $serializer->embedded($transformed, array(), $this->transformer));
    }

}
