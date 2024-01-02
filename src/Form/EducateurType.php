<?php

namespace App\Form;

use App\Entity\Licencie;
use Doctrine\DBAL\Types\JsonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
        ->add('password',TextType::class,[
            'label' => 'Mot de passe',
            'label_attr' => [
                'class' => 'form-label mt-2'
            ],
            'attr' => [
                'class' => 'form-control',
                'minlength' => 3,
                'maxlength' => 50,
                'placeholder' => 'Entrez votre mot de passe'
            ],
            'constraints' => [
                new Assert\Length([
                    'min' => 3,
                    'max' => 50,
                    'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères'
                ]),
                new Assert\NotBlank([
                    'message' => 'Le mot de passe est obligatoire'
                ])
            ]
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
