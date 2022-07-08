<?php
/**
 * @category  Aligent
 * @package
 * @author    Chris Rossi <chris.rossi@aligent.com.au>
 * @copyright 2022 Aligent Consulting.
 * @license
 * @link      http://www.aligent.com.au/
 */
namespace Aligent\ABNBundle\Tests\Unit\DependencyInjection;

use Aligent\ABNBundle\Form\EventListener\FrontendCustomerUserRegistrationTypeSubscriber;
use Aligent\ABNBundle\Form\Extension\RegistrationTypeExtension;
use Aligent\ABNBundle\Form\Type\CustomerGroupSelectType;
use Aligent\ABNBundle\DependencyInjection\AligentABNExtension;
use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;

class AligentABNExtensionTest extends ExtensionTestCase
{
    public function testLoad(): void
    {
        $this->loadExtension(new AligentABNExtension());

        // Services
        $expectedDefinitions = [
            RegistrationTypeExtension::class,
            FrontendCustomerUserRegistrationTypeSubscriber::class,
            CustomerGroupSelectType::class
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);
    }
}
