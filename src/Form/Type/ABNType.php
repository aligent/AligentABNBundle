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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Strip all whitespace so ABN can be unique
        $builder->addEventSubscriber(new StripWhitespaceSubscriber());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'pattern' => '^(\d *?){11}$',
            'constraints' => [
                new ABN()
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextType::class;
    }
}
