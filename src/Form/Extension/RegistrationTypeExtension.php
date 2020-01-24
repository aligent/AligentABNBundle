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

namespace Aligent\ABNBundle\Form\Extension;

use Aligent\ABNBundle\DependencyInjection\Configuration;
use Aligent\ABNBundle\Form\Type\ABNType;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRegistrationType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationTypeExtension extends AbstractTypeExtension
{
    /** @var  EventSubscriberInterface */
    protected $subscriber;

    /** @var ConfigManager */
    protected $configManager;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->configManager->get(Configuration::getConfigKeyByName(Configuration::ENABLED), false)) {
            $builder->add('abn', ABNType::class, [
                    'label' => 'aligent.frontend.abn.label',
                    'required' => $this->configManager->get(Configuration::getConfigKeyByName(Configuration::ABN_REQUIRED), false),
                    'mapped' => false
                ]);

            $builder->addEventSubscriber($this->subscriber);
        }
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return FrontendCustomerUserRegistrationType::class;
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function setSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @param ConfigManager $configManager
     */
    public function setConfigManager(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public static function getExtendedTypes()
    {
        return [
            FrontendCustomerUserRegistrationType::class,
        ];
    }
}
