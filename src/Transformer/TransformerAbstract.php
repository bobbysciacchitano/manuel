<?php namespace Manuel\Transformer;

abstract class TransformerAbstract {

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $relationships = array();

    /**
     * @var array
     */
    protected $linkedResources = array();

    /**
     * @var array
     */
    protected $embeddedResources = array();

    /**
     * @var array
     */
    protected $includedResources = array();

    /**
     * Return the primary key for the data array.
     *
     * @return string
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Return the name of the resource type.
     *
     * @return string
     */
    public function getTypeKey()
    {
        return $this->type;
    }

    /**
     * Return an array of simple relationship names for this resource.
     *
     * @return array
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * Return an array of linked resource names for this resource.
     *
     * @return array
     */
    public function getLinkedResources()
    {
        return $this->linkedResources;
    }

    /**
     * Return an array of embedded resource names for this resource.
     *
     * @return array
     */
    public function getEmbeddedResources()
    {
        return $this->embeddedResources;
    }

    /**
     * Return an array of resources that should be sideloaded.
     *
     * @return array
     */
    public function getIncludedResources()
    {
        return $this->includedResources;
    }

    /**
     * Add a simple identifier or relationship resource.
     *
     * @param string $name
     * @param mixed $data
     */
    public function addRelationship($name, $data)
    {
        $this->relationships[$name] = $data;
    }

    /**
     * Add link resource to serialization structure.
     *
     * @param string $name
     * @param string $link
     * @return $this
     */
    public function addLink($name, $link)
    {
        $this->linkedResources[$name] = $link;

        return $this;
    }

    /**
     * Add resource to serialization structure and define whether resource should be
     * treated as a sideload.
     *
     * @param string $name
     * @param mixed $resource
     * @param bool $sideload
     * @return $this
     */
    public function addResource($name, $resource, $sideload = false)
    {
        if ($sideload) {
            $this->includedResources[$name] = $resource;
        } else {
            $this->embeddedResources[$name] = $resource;
        }

        return $this;
    }

}
