Manuel
======

[![Build Status](https://travis-ci.org/bobbysciacchitano/manuel.svg?branch=master)](https://travis-ci.org/bobbysciacchitano/manuel) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/768651b6-0cfb-4bed-90d9-54d1ce1b8b81/mini.png)](https://insight.sensiolabs.com/projects/768651b6-0cfb-4bed-90d9-54d1ce1b8b81)

The easy to use PHP Serializer. Because translation shouldn't be a chore.

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
            'active'       => (bool) $myObject->is_active
        );
    }

    /**
     * Define other resources to be included in transformation.
     *
     * @param TheObject $myObject
     */
    public function resources(TheObject $myObject)
    {
        $this->addLink("/customer/{$myObject->id}/tasks");

        $this->addRelationship('organisation', $myObject->organisation_id);
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

Simple relationships can be used to contrive additional data or return a simple value. When used with the JsonAPI serializer, this type of resource relationship can be used to declare a reference to an object that is not embedded or side-loaded.

**Linked Resources**

Much like simple relationships, this type of resource can be used to create a link reference to another resource that can be loaded from the API.

**Embedded Resources**

Much like simple relationships, embedded resources can be used to nest another resource within the resource tree. Embedded resources can be either a ```Collection``` or ```Item``` and the serializer will attempt to serialize all relationships underneath.

```php
    /**
     * Define other resources to be included in transformation.
     *
     * @param TheObject $myObject
     */
    public function resources(TheObject $myObject)
    {
        $this->addResource('test_item', new Item($data->item, new Transformer));

        $this->addResource('test_collection', new Collection($data->items, new Transformer));
    }
```

**Sideloaded Resources**

This type of resource will be included along side the main resource and references to the resource identifiers can be loaded as part of the relationship serialization.

```php
    /**
     * Define other resources to be included in transformation.
     *
     * @param TheObject $myObject
     */
    public function resources(TheObject $myObject)
    {
        $this->addResource('test_item', new Item($data->item, new Transformer), true);

        $this->addResource('test_collection', new Collection($data->items, new Transformer), true);
    }
```
#### Serializers

Manuel out of the box includes a basic implementation of the JsonAPI serializer. The abstract serializer includes a flexible API which can form the basis for your own serializer.
