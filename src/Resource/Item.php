<?php namespace Manuel\Resource;

use Manuel\Helper\ResourceBag;
use Manuel\Serializer\SerializerAbstract;

class Item extends ResourceAbstract {

    /**
     * @inheritdoc
     */
    public function create(SerializerAbstract $serializer)
    {
        // If data is empty, do nothing.
        if (!$this->data) {
            return null;
        }

        // Create a new Resource bag for transforming relationships.
        $resourceBag = new ResourceBag($this->data, $this->transformer, $serializer);

        // Transform raw data into correct format/s
        $transformed = $this->transformer->transform($this->data);

        // Convert into final resource object
        $resource = $serializer->item($transformed, $this->transformer);

        // Pull relationships into the correct format
        $relationships = $serializer->relationships($resourceBag, $this->transformer);

        return array_merge($resource, $relationships);
    }

    /**
     * @inheritdoc
     */
    public function identifiers()
    {
        // Transform raw data into correct format/s
        $transformed = $this->transformer->transform($this->data);

        return $transformed[$this->transformer->getPrimaryKeyName()];
    }

}
