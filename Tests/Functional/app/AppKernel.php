<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * App Test Kernel for functional tests.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new IR\Bundle\CustomerBundle\Tests\Functional\Bundle\TestBundle\TestBundle(),
            new IR\Bundle\CustomerBundle\IRCustomerBundle(),
        );
    }    

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }    
    
    public function getCacheDir()
    {
        return sys_get_temp_dir().'/IRCustomerBundle/cache';
    }    
    
    public function getLogDir()
    {
        return sys_get_temp_dir().'/IRCustomerBundle/logs';
    }    
}
