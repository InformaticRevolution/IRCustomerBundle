<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Registration Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegistrationType extends BaseType
{
    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {                
        parent::buildForm($builder, $options);
     
        $builder->remove('username');
    }

    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_customer_registration';
    }   
}