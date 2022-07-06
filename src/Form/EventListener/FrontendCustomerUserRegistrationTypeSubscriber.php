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

namespace Aligent\ABNBundle\Form\EventListener;

use Aligent\ABNBundle\DependencyInjection\Configuration;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\EntityBundle\ORM\Registry;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FrontendCustomerUserRegistrationTypeSubscriber implements EventSubscriberInterface
{
    /** @var $registry Registry */
    protected $registry;

    /** @var ConfigManager  */
    protected $configManager;

    /**
     * FrontendCustomerUserRegistrationTypeSubscriber constructor.
     * @param Registry $registry
     * @param ConfigManager $configManager
     */
    public function __construct(
        Registry $registry,
        ConfigManager $configManager
    ) {
    
        $this->configManager = $configManager;
        $this->registry = $registry;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    /**
     * @param FormEvent $formEvent
     */
    public function postSubmit(FormEvent $formEvent)
    {
        if ($this->configManager->get(Configuration::getConfigKeyByName(Configuration::ENABLED), false)) {
            /** @var CustomerUser $customerUser */
            $customerUser = $formEvent->getData();
            /** @var Customer $customer */
            $customer = $customerUser->getCustomer();
            $form = $formEvent->getForm();
            if ($form->has('abn') && !empty($form->get('abn')->getData())) {
                $abn = $form->get('abn')->getData();
                $customer->setBusinessNumber($abn);
                $this->setDefaultGroup($customer, Configuration::WITH_ABN_GROUP);
            } else {
                $this->setDefaultGroup($customer, Configuration::NO_ABN_GROUP);
            }
        }
    }

    /**
     * Set the default group of the user if it is set and exists
     * @param Customer $customer
     * @param string $paramName
     */
    protected function setDefaultGroup(Customer $customer, string $paramName)
    {
        $groupId = $this->configManager->get(Configuration::getConfigKeyByName($paramName));
        if (isset($groupId)) {
            $group = $this->registry
                ->getRepository(CustomerGroup::class)
                ->find($groupId);
            $customer->setGroup($group);
        }
    }
}
