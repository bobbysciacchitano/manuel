<?php namespace Manuel\Resource;

use Manuel\Helper\ResourceBag;
use Manuel\Serializer\SerializerAbstract;

class Item extends ResourceAbstract {

    /**
     * @inheritdoc
     */
    public function create(SerializerAbstract $serializer)
    {
        // Create a new Resource bag for transforming relationships.
        $resourceBag = new ResourceBag($this->data, $this->transformer, $serializer);

        // Transform raw data into correct format/s
        $transformed = $this->transformer->transform($this->data);

        // Convert into final resource object
        $resource = $serializer->item($transformed, $this->transformer);

        // Pull relationships into the correct format
        $embedded = $serializer->relationships($resourceBag, $this->transformer);

        return array_merge($resource, $embedded);
    }

}
