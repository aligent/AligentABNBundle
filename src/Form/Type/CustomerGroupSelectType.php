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

namespace Aligent\ABNBundle\Form\Type;

use Doctrine\Common\Persistence\ManagerRegistry;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerGroupRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerGroupSelectType extends AbstractType
{
    /** @var ManagerRegistry */
    protected $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }


    public function getName()
    {
        return 'alg_customer_customer_group_select';
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('placeholder', 'aligent.abn.form.group_choice.placeholder');
        $resolver->setNormalizer(
            'choices',
            function (OptionsResolver $options) {
                /** @var CustomerGroupRepository $repo */
                $groups = $this->registry->getRepository(CustomerGroup::class)->findAll();

                $result = [];
                foreach ($groups as $group) {
                    $result[$group->getId()] = $group->getName();
                }

                return $result;
            }
        );
    }


    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
