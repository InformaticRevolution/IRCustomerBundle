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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use IR\Bundle\CustomerBundle\Model\Titles;

/**
 * Title Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class TitleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */     
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'expanded'=> true,
            'choices' => Titles::getTitles(),
        ));
    }    
    
    /**
     * {@inheritdoc}
     */     
    public function getParent()
    {
        return 'choice';
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_customer_title';
    }   
}