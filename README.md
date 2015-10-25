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
    protected $relationships = [ 'organisation' ];

    /**
     * @var array
     */
    protected $linkedResources = [ 'tasks' ];

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

    /**
     * Create link to external resource.
     *
     * @param TheObject $myObject
     * @return Link
     */
    public function linkedTasks(TheObject $myObject)
    {
        return "/customer/{$myObject->id}/tasks";
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
            "organisation": {
                "data": {
                    "id": 5,
                    "type": "organisation"
                }
            },
            "tasks": {
                "links": {
                    "related": "/customer/1/tasks"
                }
            }
        }
    }
}
```

#### Associations

Manuel can handle an variety of association types. It is the responsibility of the serializer to translate the relationship into the correct format.

**Simple Relationship**

This type supports registering a property on the transformed object as a resource which can be used as part of translation later on. In the above example, the ```organisation``` attribute is used to create a relationship of organisation to customer.

If the relationship is an array, Manuel will iterate and return as required.

**Linked Resources**

Linked resources can create a URI reference to a relationship or complex data set. To create a linked resource, add the resource to the ```$linkedResources``` array then creating a method starting with ```linked``` which will return a string containing the link.

#### Work in progress

* Unit tests
* Embedded includes
* Sideloaded includes
* Improve documentation
