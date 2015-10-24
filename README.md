Manuel
======

The easy to use PHP Serializer. Because translation shouldn't be a chore.

This project was heavily inspired by PHP League's Fractal project.

#### How to use

To serialize an object you first need to create a transformer. Transformers must implement the transform method and return an array. Transformers can accept any type of data or object that requires serialisation.

```php
<?php namespace App\Transformer;

use TheObject;
use Manuel\Transformer\TransformerAbstract;

class MyTransformer extends TransformerAbstract {

    /**
     * @var array
     */
    protected $relationships = [ 'business' => 'organisation' ];

    /**
     * Transform object properties.
     *
     * @param TheObject $myObject
     * @return array
     */
    public function transform(TheObject $myObject)
    {
        return array(
            'id'           => (int) $myObject->id,
            'name'         => $myObject->name,
            'email'        => $myObject->email,
            'active'       => (bool) $myObject->is_active,
            'organisation' => (int) $myObject->organisation_id
        );
    }

}
```

To serialize your data into a resource, you can wrap it in a Resource object. Wrapping the data into in a Resource tells Manuel whether you want to return a collection or a single resource.

```php
<?php

use Manuel\Manager;
use Manuel\Resource;
use App\Transformer;

// Serialize a object
$manager = new Manager(new Resource\Item($data, new Transfomer\MyTransformer, 'item'), new JsonAPISerializer);

$translated = $manager->translate();

// Serialize an array or collection of objects
$manager = new Manager(new Resource\Collection($array, new Transfomer\MyTransformer, 'item'), new JsonAPISerializer);

$translated = $manager->translate();
```

#### Relationships

Currently, Manuel can only translate relationships which do not need to be sidedloaded or embedded. This is useful for APIs that have large or expensive relationships that may not needed to be always loaded.

In the transformer above, this is represented by the ```$relationships``` property. The selected serializer will then transform properties which have been identified as a simple relationships into the appropriate format.

#### Work in progress

* Sideloaded includes
* Embedded includes
* Link relationships representation
* Improved documentation
* Unit tests
* License
