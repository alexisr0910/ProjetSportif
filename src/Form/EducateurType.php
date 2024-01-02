<?php

namespace App\Form;

use App\Entity\Educateur;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class EducateurType extends AbstractType
{

    /**
     * Construction du formulaire 
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType::class,[
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form-label mt-2'
            ],
            'attr' => [
                'class' => 'form-control',
                'minlength' => 3,
                'maxlength' => 50,
                'placeholder' => 'Entrez votre email'
            ],
            'constraints' => [
                new Assert\Length([
                    'min' => 3,
                    'max' => 50,
                    'minMessage' => 'L\'email doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'L\'email doit contenir au maximum {{ limit }} caractères'
                ]),
                new Assert\NotBlank([
                    'message' => 'L\'email est obligatoire'
                ])
            ]
        ])
        ->add('plainPassword', RepeatedType::class, [
            'label' => 'password',
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 50,
                    'placeholder' => 'Entrez votre mot de passe',
                ],
            ],
            'second_options' => [
                'label' => 'Répétez le mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 50,
                    'placeholder' => 'Répétez votre mot de passe',
                ],
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le mot de passe est obligatoire',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 50,
                    'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères',
                ]),
            ],
        ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Ajouter'
            ])
        ;
    }

    /**
     * Configure les options spécifiques du formulaire
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Educateur::class,
        ]);
    }
}
