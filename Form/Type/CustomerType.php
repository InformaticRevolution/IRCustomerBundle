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

use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\FormBuilderInterface;
use IR\Bundle\CustomerBundle\Form\EventListener\BuildCustomerFormListener;

/**
 * Customer Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CustomerType extends ProfileFormType
{
    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);
        
        $builder
            ->add('plainPassword', 'password', array(
                'label' => 'form.customer.password',
                'translation_domain' => 'ir_customer',
                'validation_groups' => 'NewCustomer',
            ))                
            ->add('enabled', 'checkbox', array(
                'label' => 'form.customer.enabled',
                'translation_domain' => 'ir_customer',
            ))             
            ->remove('username')
            ->addEventSubscriber(new BuildCustomerFormListener());
    }

    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_customer';
    }   
}