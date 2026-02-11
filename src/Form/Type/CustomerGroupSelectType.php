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

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerGroupRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerGroupSelectType extends AbstractType
{
    protected ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function getName(): string
    {
        return 'aligent_abn_customer_group_select';
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('placeholder', 'aligent.abn.form.group_choice.placeholder');
        $resolver->setNormalizer(
            'choices',
            function (OptionsResolver $options) {
                /** @var CustomerGroupRepository $repo */
                $groups = $this->registry->getRepository(CustomerGroup::class)->findAll();

                $result = [];
                foreach ($groups as $group) {
                    $result[$group->getName()] = $group->getId();
                }

                return $result;
            }
        );
    }


    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}
