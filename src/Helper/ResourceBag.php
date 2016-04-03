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
        $this->transformer = $transformer;
        $this->serializer  = $serializer;
    }

    /**
     * Return true if a item contains any simple or linked relationships.
     *
     * @return boolean
     */
    public function containsRelationships() {
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

            $methodName = $this->camelizeString('relationship', !is_numeric($key) ? $key : $resource);

            $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->simple($this->transformer->{$methodName}($this->data), $resource);
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

            $methodName = $this->camelizeString('linked', $resource);

            $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->link($this->transformer->{$methodName}($this->data), $resource);
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

            $methodName = $this->camelizeString('embedded', $resource);

            $transformer = $this->transformer->{$methodName}($this->data);

            if ($transformer) {
                $data = $transformer->create($this->serializer);

                $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->embedded($data, $resource);
            }
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

            $methodName = $this->camelizeString('include', $resource);

            $item = $this->transformer->{$methodName}($this->data);
            if ($item) {
                $data = $item->identifiers($this->serializer);

                $resources[!is_numeric($key) ? $key : $resource] = $this->serializer->sideload($data, $item->getTransformer()->getTypeKey());
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

          $methodName = $this->camelizeString('include', $resource);

          $item = $this->transformer->{$methodName}($this->data);

          if ($item) {
            $data = $item->create($this->serializer);

            if ($group) {
                $resources[!is_numeric($key) ? $key : $resource] = $data;
            } else {
                if($item->returnsCollection()) {
                    $resources = array_merge($resources, $data);
                } else {
                    $resources[] = $data;
                }
            }
          }
      }

      return $resources;
    }

    /**
     * Return a camelized string reference to a method that should
     * be loaded from the item.
     *
     * @param string $key
     * @param string $resource
     * @return string
     */
    private function camelizeString($type, $resource)
    {
        return $type . implode('', array_map('ucfirst', array_map('strtolower', preg_split('/[\s_-]/', $resource))));
    }

}
