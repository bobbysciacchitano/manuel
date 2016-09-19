<?php namespace Manuel\Helper;

use Manuel\Resource\ResourceAbstract;
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
    protected $serializer;

    /**
     * Create a new resource bag object for organising references to related
     * objects.
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

        if (method_exists($transformer, 'resources')) {
            $this->transformer->resources($data);
        }
    }

    /**
     * Return true if a item contains any simple or linked relationships.
     *
     * @return boolean
     */
    public function containsResources() {
        if (
          $this->transformer->getRelationships() ||
          $this->transformer->getLinkedResources() ||
          $this->transformer->getEmbeddedResources() ||
          $this->transformer->getIncludedResources()
        ) {
            return true;
        }
    }

    /**
     * Returns true if the item contains any simple relationships.
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
     * Return an array of serialized simple relationships.
     *
     * @return array
     */
    public function fetchSimple()
    {
        $resources = array();

        foreach ($this->transformer->getRelationships() as $key => $resource) {
            $resources[$key] = $this->serializer->simple($resource, $key);
        }

        return $resources;
    }

    /**
     * Returns true if item contains any linked relationships.
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
     * Returns an array of serialized linked relationships.
     *
     * @return array
     */
    public function fetchLinks()
    {
        $resources = array();

        foreach ($this->transformer->getLinkedResources() as $key => $resource) {
            $resources[$key] = $this->serializer->link($resource, $key);
        }

        return $resources;
    }

    /**
     * Returns true if item contains any embedded resources..
     *
     * @return boolean
     */
    public function containsEmbedded()
    {
        if ($this->transformer->getEmbeddedResources()) {
            return true;
        }
    }

    /**
     * Returns an array of serialized embedded relationships.
     *
     * @return array
     */
    public function fetchEmbedded()
    {
        $resources = array();

        foreach ($this->transformer->getEmbeddedResources() as $key => $resource) {

            if ($resource instanceof ResourceAbstract) {
                $data = $resource->create($this->serializer);
            } else {
                $data = $resource;
            }

            $resources[$key] = $this->serializer->embedded($data, $key);
        }

        return $resources;
    }

    /**
     * Returns true if item contains any resources that should be sideloaded.
     *
     * @return boolean
     */
    public function containsIncludes()
    {
        if ($this->transformer->getIncludedResources()) {
            return true;
        }
    }

    /**
     * Returns an array of sideloadable relationships.
     *
     * @return array
     */
    public function fetchSideloads()
    {
        $resources = array();

        foreach ($this->transformer->getIncludedResources() as $key => $resource) {
            if ($resource instanceof ResourceAbstract) {
                $data = $resource->identifiers($this->serializer);

                $resources[$key] = $this->serializer->sideload($data, $resource->getTransformer()->getTypeKey());
            }
        }

        return $resources;
    }

    /**
     * Returns an array of relationships that should be sideloaded.
     *
     * @param boolean $group
     * @return array
     */
    public function sideloadResources($group = true)
    {
      $resources = array();

      foreach ($this->transformer->getIncludedResources() as $key => $resource) {
          if ($resource instanceof ResourceAbstract) {
              $data = $resource->create($this->serializer);

              if ($group) {
                  $resources[!is_numeric($key) ? $key : $resource] = $data;
              } else {
                  if($resource->returnsCollection()) {
                      $resources = array_merge($resources, $data);
                  } else {
                      $resources[] = $data;
                  }
              }
          } else {

          }

      }

      return $resources;
    }

}
