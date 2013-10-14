Using Addresses With IRCustomerBundle
=====================================

## Installation

1. Create your Address class
2. Define the Customer-Address relation
3. Configure the addresses
4. Import the routing file
5. Update your database schema

### Step 1: Create your Address class

##### Annotations
``` php
<?php
// src/Acme/CustomerBundle/Entity/Address.php

namespace Acme\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\CustomerBundle\Model\Address as BaseAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_customer_address")
 */
class Address extends BaseAddress
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/CustomerBundle/Entity/Address.php

namespace Acme\CustomerBundle\Entity;

use IR\Bundle\CustomerBundle\Model\Address as BaseAddress;

/**
 * Address.
 */
class Address extends BaseAddress
{
}
```

In YAML:

``` yaml
# src/Acme/CustomerBundle/Resources/config/doctrine/Address.orm.yml
Acme\CustomerBundle\Entity\Address:
    type:  entity
    table: acme_customer_address

    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/CustomerBundle/Resources/config/doctrine/Address.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\CustomerBundle\Entity\Address" table="acme_customer_address">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

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
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer", cascade={"all"}, orphanRemoval=true)
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
 * Customer.
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

    oneToMany:
        addresses:
            targetEntity: Address
            mappedBy: customer
            cascade: [ all ]
            orphanRemoval: true 
```

In XML:

``` xml
<!-- src/Acme/CustomerBundle/Resources/config/doctrine/Customer.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\CustomerBundle\Model\Customer" table="acme_customer">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id>

        <one-to-many field="addresses" target-entity="Address" mapped-by="customer" orphan-removal="true">
            <cascade>
                <cascade-all />
            </cascade>            
        </one-to-many>
    </entity>
    
</doctrine-mapping>
```

### Step 3: Configure the addresses

Add the following configuration to your `config.yml` file:

**a) Add the address configuration**

``` yaml
# app/config/config.yml
ir_customer:
    db_driver: orm # orm is the only available driver for the moment 
    address:
        address_class: Acme\CustomerBundle\Entity\Address
```

**b) Add the CustomerInterface path to the RTEL**

``` yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            IR\Bundle\CustomerBundle\Model\CustomerInterface: Acme\CustomerBundle\Entity\Customer
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