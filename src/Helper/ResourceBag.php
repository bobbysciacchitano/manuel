<?php namespace Manuel\Helper;

use Manuel\Serializer\SerializerAbstract;
use Manuel\Transformer\TransformerAbstract;

class ResourceBag {

	/**
	 * @var array
	 */
	protected $resources;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * @var SerializerAbstract
     */

    /**
     *
     *
     * @param mixed $data
     * @param TransformerAbstract $transformer
     * @param SerializerAbstract $serializer
     */
    public function __construct($data, TransformerAbstract $transformer, SerializerAbstract $serializer)
    {
        $this->data = $data;

        $this->serializer  = $serializer;

        $this->transformer = $transformer;
    }

    /**
     *
     *
     * @return boolean
     */
    public function containsRelationships() {
        if ($this->transformer->getRelationships() || $this->transformer->getLinkedResources()) {
            return true;
        }
    }

    /**
     *
     *
     * @return boolean
     */
    public function containsSimple()
    {
        if ($this->transformer->getRelationships()) {
            return true;
        }
    }

    /**
     *
     *
     * @return array
     */
    public function fetchSimple()
    {
        $resources = array();

        foreach ($this->transformer->getRelationships() as $key => $resource) {

            $methodName = $this->camelizeString('relationship', !is_numeric($key) ? $key : $resource);

            $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->simple($this->transformer->{$methodName}($this->data), $resource);
        }

        return $resources;
    }

    /**
     *
     *
     * @return boolean
     */
    public function containsLinks()
    {
        if ($this->transformer->getLinkedResources()) {
            return true;
        }
    }

    /**
     *
     *
     * @return array
     */
    public function fetchLinks()
    {
        $resources = array();

        foreach ($this->transformer->getLinkedResources() as $key => $resource) {

            $methodName = $this->camelizeString('linked', $resource);

            $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->link($this->transformer->{$methodName}($this->data), $resource);
        }

        return $resources;
    }

    /**
     *
     *
     * @param string $key
     * @param string $resource
     * @return string
     */
    private function camelizeString($type, $resource)
    {
        return $type . implode('', array_map('ucfirst', array_map('strtolower', explode('-', $resource))));
    }

}
