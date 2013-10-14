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
use FOS\UserBundle\Form\Type\ProfileFormType;

/**
 * Account Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AccountType extends ProfileFormType
{
    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'ir_customer_title', array(
                'label' => 'form.customer.title', 
                'translation_domain' => 'ir_customer',                
            ))        
            ->add('firstName', null, array(                 
                'label' => 'form.customer.first_name',
                'translation_domain' => 'ir_customer',
            )) 
            ->add('lastName', null, array(                 
                'label' => 'form.customer.last_name',
                'translation_domain' => 'ir_customer',
            ))           
        ;      
        
        parent::buildForm($builder, $options);
        $builder->remove('username');        
    }

    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_customer_account';
    }   
}