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
    protected EventSubscriberInterface $subscriber;

    protected ConfigManager $configManager;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($this->configManager->get(Configuration::getConfigKeyByName(Configuration::ENABLED), false)) {
            $builder->add('abn', ABNType::class, [
                    'label' => 'aligent.frontend.abn.label',
                    'required'
                        => $this->configManager->get(Configuration::getConfigKeyByName(Configuration::ABN_REQUIRED)),
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
    public function getExtendedType(): string
    {
        return FrontendCustomerUserRegistrationType::class;
    }

    public function setSubscriber(EventSubscriberInterface $subscriber): void
    {
        $this->subscriber = $subscriber;
    }

    public function setConfigManager(ConfigManager $configManager): void
    {
        $this->configManager = $configManager;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            FrontendCustomerUserRegistrationType::class,
        ];
    }
}
