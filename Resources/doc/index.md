Getting Started With IRCustomerBundle
=====================================

The bundle is built on top of FOSUserBundle. This documentation only deals with
the minimal required configuration to run IRCustomerBundle. Read the bundle
[documentation](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md)
to learn about more advanced features.

## Prerequisites

This version of the bundle requires Symfony 2.3+.

## Installation

1. Download IRCustomerBundle using composer
2. Enable the Bundles
3. Create your Customer class
4. Configure your application's security.yml
5. Configure the FOSUserBundle
6. Configure the IRCustomerBundle
7. Import IRCustomerBundle routing
8. Update your database schema
9. Enable the doctrine extensions

### Step 1: Download IRCustomerBundle using composer

Add IRCustomerBundle in your composer.json:

``` js
{
    "require": {
        "informaticrevolution/customer-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/customer-bundle
```

### Step 2: Enable the bundles

Enable the bundles in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\UserBundle\FOSUserBundle(),
        new IR\Bundle\CustomerBundle\IRCustomerBundle(),
    );
}
```

### Step 3: Create your Customer class

**Warning:**

> If you override the __construct() method in your Customer class, be sure
> to call parent::__construct(), as the base Customer class depends on
> this to initialize some fields.

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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
```

In XML:

``` xml
<!-- src/Acme/CustomerBundle/Resources/config/doctrine/Customer.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\CustomerBundle\Entity\Customer" table="acme_customer">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### Step 4: Configure your application's security.yml

Add the bundle minimal configuration to your `security.yml` file:


``` yaml
# app/config/security.yml
security:
    encoders:
        FOS\UserBundle\Model\UserInterface: sha512

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    firewalls:
        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_provider: form.csrf_provider
            logout: true
            anonymous: true

    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/, role: ROLE_ADMIN }
```

### Step 5: Configure the FOSUserBundle

Add the bundle minimal configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
fos_user:
    firewall_name: main
    user_class: Acme\CustomerBundle\Entity\Customer
```

**Note:**

Do not configure the `db_driver`. You will add it instead in the IRCustomerBundle configuration.

### Step 6: Configure the IRCustomerBundle

Add the bundle minimal configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_customer:
    db_driver: orm # orm is the only available driver for the moment 
```

### Step 7: Import IRCustomerBundle routing files

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_customer_admin_customer:
    resource: "@IRCustomerBundle/Resources/config/routing/admin/customer.xml"
    prefix: /admin/customers
```

### Step 8: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 9: Enable the doctrine extensions

**a) Enable the stof doctrine extensions bundle in the kernel**

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
}
```

**b) Enable the timestampable extension in your `config.yml` file**

``` yaml
# app/config/config.yml
stof_doctrine_extensions:
    orm:
        default:
            timestampable: true
```

### Next Steps

- [Using the addresses](addresses.md)
