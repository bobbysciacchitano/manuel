<?php namespace Manuel\Resource;

use Manuel\Serializer\SerializerAbstract;

class Collection extends ResourceAbstract {

    /**
     * @inheritdoc
     */
    protected $returnsCollection = true;

    /**
     * @inheritdoc
     */
    public function create(SerializerAbstract $serializer)
    {
        $resources = array();

        foreach ($this->data as $data) {

            $resource = new Item($data, $this->transformer, $this->resourceKey);

            $resources[] = $resource->create($serializer);
        }

        return $resources;
    }

    /**
     * @inheritdoc
     */
    public function identifiers()
    {
        $resources = array();

        foreach ($this->data as $data) {

            $resource = new Item($data, $this->transformer, $this->resourceKey);

            $resources[] = $resource->identifiers();
        }

        return $resources;
    }

}
