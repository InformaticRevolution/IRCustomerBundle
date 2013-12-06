<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Build Customer Form Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class BuildCustomerFormListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * Removes the plain password when editing customer.
     *
     * @param DataEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $customer = $event->getData();
        $form = $event->getForm();

        if (null === $customer || !$customer->getId()) {
            return;
        }
        
        $form->remove('plainPassword');
    }
}