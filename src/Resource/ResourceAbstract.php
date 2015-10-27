<?php namespace Manuel\Resource;

use Manuel\Helper\ResourceBag;
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
        // Transform raw data into correct format/s
        $transformed = $this->transformer->transform($this->data);

        // Convert into final resource object
        $resource = $serializer->item($transformed, $this->transformer);

        $resourceBag = new ResourceBag($this->data, $this->transformer, $this->serializer);
        $resourceBag->create();

        // Pull embedded relationships into the correct format
        $embedded = $serializer->embedded($resourceBag, $this->transformer);

        return array_merge($resource, $embedded);
    }

}
