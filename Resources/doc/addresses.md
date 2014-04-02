Using Addresses With IRCustomerBundle
=====================================

## Installation

1. Install the IRAddressBundle
2. Define the Customer-Address relation
3. Configure the addresses
4. Import the routing file
5. Update your database schema

### Step 1: Install the IRAddressBundle

The installation instructions are located in the IRAddressBundle documentation.

[Read the Documentation](https://github.com/InformaticRevolution/IRAddressBundle/blob/master/Resources/doc/index.md)

### Step 2: Define the Customer-Address relation

##### Annotations

``` php
<?php
// src/Acme/CustomerBundle/Entity/Customer.php

namespace Acme\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\CustomerBundle\Model\Customer as BaseCustomer;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_customer")
 */
class Customer extends BaseCustomer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $billingAddress;
    
    /**
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $shippingAddress;

    /**
     * @ORM\ManyToMany(targetEntity="Address", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="customers_addresses",
     *      joinColumns={@ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     *  )
     */
    protected $addresses;


    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/CustomerBundle/Entity/Customer.php

namespace Acme\CustomerBundle\Entity;

use IR\Bundle\CustomerBundle\Model\Customer as BaseCustomer;

/**
 * Customer implementation.
 */
class Customer extends BaseCustomer
{
    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/CustomerBundle/Resources/config/doctrine/Customer.orm.yml
Acme\CustomerBundle\Entity\Customer:
    type:  entity
    table: acme_customer

    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    oneToOne:
        billingAddress:
            targetEntity: Address
            joinColumn:
                name: billing_address_id
                referencedColumnName: id
                onDelete: SET NULL

        shippingAddress:
            targetEntity: Address
            joinColumn:
                name: shipping_address_id
                referencedColumnName: id
                onDelete: SET NULL

    manyToMany:
        addresses:
            targetEntity: Address
            cascade: [ all ]
            orphanRemoval: true
            joinTable:
                name: customers_addresses
                joinColumns:
                    customer_id:
                        referencedColumnName: id
                        onDelete: CASCADE
                inverseJoinColumns:
                    address_id:
                        referencedColumnName: id 
                        unique: true
                        onDelete: CASCADE
```

In XML:

``` xml
<!-- src/Acme/CustomerBundle/Resources/config/doctrine/Customer.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\CustomerBundle\Model\Customer" table="acme_customer">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id>

        <one-to-one field="billingAddress" target-entity="Address">
            <join-column name="billing_address_id" referenced-column-name="id" on-delete="SET NULL" />           
        </one-to-one>  

        <one-to-one field="shippingAddress" target-entity="Address">
            <join-column name="shipping_address_id" referenced-column-name="id" on-delete="SET NULL" />           
        </one-to-one>   

        <many-to-many field="addresses" target-entity="Address" orphan-removal="true">
            <cascade>
                <cascade-all/>
            </cascade>
            <join-table name="customers_addresses">
                <join-columns>
                    <join-column name="customer_id" referenced-column-name="id" on-delete="CASCADE" />
                </join-columns>
                <inverse-join-columns>
                    <join-column name="address_id" referenced-column-name="id" unique="true" on-delete="CASCADE" />
                </inverse-join-columns>
            </join-table>
        </many-to-many>
    </entity>
    
</doctrine-mapping>
```

### Step 3: Configure the addresses

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_customer:
    db_driver: orm # orm is the only available driver for the moment 
    address: ~
```

### Step 4: Import the routing file

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_customer_address:
    resource: "@IRCustomerBundle/Resources/config/routing/address.xml"
    prefix: /account/addresses

```

### Step 5: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```