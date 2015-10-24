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
     * @param array $data
     * @param array $includes
     * @param TransformerAbstract $transformer
     * @return array
     */
    public function embedded(array $data, array $includes = null, TransformerAbstract $transformer)
    {
        return array_merge($data, $includes);
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
