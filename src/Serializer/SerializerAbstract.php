<?php namespace Manuel\Serializer;

use Manuel\Transformer\TransformerAbstract;

class SerializerAbstract {

    /**
     * @return string
     */
    protected $resourceKey;

    /**
     *
     *
     * @param array $data
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function item(array $data, TransformerAbstract $transformer)
    {
        return $data;
    }

    /**
     *
     *
     * @param array $data
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function collection(array $data, TransformerAbstract $transformer)
    {
        return $data;
    }

    /**
     *
     *
     * @param array $resources
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function embedded(array $resources, TransformerAbstract $transformer)
    {
        return $resources;
    }

    /**
     *
     *
     * @param array $data
     * @param array $includes
     * @return array
     */
    public function payload(array $data, array $includes = array())
    {
        $payload = array($data);

        foreach ($includes as $include) {
            $payload[] = $include;
        }

        return $payload;
    }

}
