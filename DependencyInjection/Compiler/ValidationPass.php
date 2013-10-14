<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Validation Pass.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ValidationPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('ir_customer.db_driver')) {
            return;
        }

        $dbDriver = $container->getParameter('ir_customer.db_driver');
        
        if (!$container->hasParameter('validator.mapping.loader.xml_files_loader.mapping_files')) {
            return;
        }

        $files = $container->getParameter('validator.mapping.loader.xml_files_loader.mapping_files');
        $validationFile = __DIR__.'/../../Resources/config/validation/'.$dbDriver.'.xml';

        if (is_file($validationFile)) {
            $files[] = realpath($validationFile);
            $container->addResource(new FileResource($validationFile));
        }

        $container->setParameter('validator.mapping.loader.xml_files_loader.mapping_files', $files);
    }
}