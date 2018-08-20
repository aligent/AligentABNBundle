<?php
/**
 *
 *
 * @category  Aligent
 * @package
 * @author    Adam Hall <adam.hall@aligent.com.au>
 * @copyright 2018 Aligent Consulting.
 * @license
 * @link      http://www.aligent.com.au/
 */

namespace Aligent\ABNBundle\Form\EventSubscriber;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StripWhitespaceSubscriber implements EventSubscriberInterface
{
    /**
     * @param FormEvent $event
     */
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (is_string($data)) {
            $event->setData(preg_replace("/\s/", "", $data));
        }
    }

    static public function getSubscribedEvents()
    {
        return [FormEvents::SUBMIT => 'onSubmit'];
    }
}