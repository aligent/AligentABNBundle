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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class StripWhitespaceSubscriber implements EventSubscriberInterface
{
    public function onSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        if (is_string($data)) {
            $event->setData(preg_replace("/\s/", "", $data));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [FormEvents::SUBMIT => 'onSubmit'];
    }
}
