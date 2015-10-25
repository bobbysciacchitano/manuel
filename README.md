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
     * @var string
     */
    protected $type = 'customer';

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

To serialize your data into a resource, you can wrap it in a Resource object. Wrapping the data into in a Resource tells Manuel whether you want to return a collection or a single resource. You can also declare your own resource types.

```php
<?php

use Manuel\Manager;
use Manuel\Resource;
use App\Transformer;

$manager = new Manager(new JsonAPISerializer);

// Serialize a object
$translated = $manager->translate(new Resource\Item($data, new Transfomer\MyTransformer));

// Serialize an array or collection of objects
$translated = $manager->translate(new Resource\Collection($array, new Transfomer\MyTransformer));
```

The above transformer with the Json API serializer will generate the following representation:

```json
{
    "data": {
        "id": 1,
        "type": "customer",
        "attributes": {
            "name": "Johnny",
            "email": "johnny@test.com",
            "active": true
        },
        "relationships": {
            "business": {
                "data": {
                    "id": 5,
                    "type": "organisation"
                }
            }
        }
    }
}
```

#### Associations

Manuel can handle an assortment of association types. It is the responsibility of the serializer to translate the relationship into the correct format.

**Simple Relationship**

This type supports returning a speciifc value and translating it to another attribute name. In the example above the attribute ```organisation``` will be transformed the attribute ```business```. This is useful for representing relationships which may be loaded async.

#### Work in progress

* Sideloaded includes
* Embedded includes
* Link relationships representation
* Improve documentation
* Unit tests
* License
