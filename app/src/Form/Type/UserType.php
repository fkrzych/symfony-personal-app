<?php
/**
 * User type.
 */

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType.
 */
class UserType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder FormBuilderInterface
     * @param array<string, mixed> $options array<string, mixed>
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            TextType::class,
            [
                'label' => 'label.user_email',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );
        if (in_array('ROLE_ADMIN', $options['role'])) {
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'label.block',
                    'choices' => ['label.blocked' => 'ROLE_BLOCKED'],
                    'expanded' => true,
                    'multiple' => true,
                ]
            );
        }
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver OptionsResolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class, 'role' => ['ROLE_USER']]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string Block Prefix
     */
    public function getBlockPrefix(): string
    {
        return 'user';
    }
}
