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
     *
     *
     * @return string
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    /**
     *
     *
     * @return string
     */
    public function getTypeKey()
    {
        return $this->type;
    }

    /**
     *
     *
     * @return array
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     *
     *
     * @return array
     */
    public function getLinkedResources()
    {
        return $this->linkedResources;
    }

}
