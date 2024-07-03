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

use Aligent\ABNBundle\Form\EventSubscriber\StripWhitespaceSubscriber;
use Aligent\ABNBundle\Validator\Constraints\ABN;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ABNType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Strip all whitespace so ABN can be unique
        $builder->addEventSubscriber(new StripWhitespaceSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'pattern' => '^(\d *?){11}$',
            'constraints' => [
                new ABN()
            ]
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return TextType::class;
    }
}
