<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\licencie;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '200'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 200, 'minMessage' => 'Le nom doit faire 2 caractères minimum', 'maxMessage' => 'Le nom dois faire 200 caractères maximum ']),
                    new Assert\NotBlank()
                ]
            ])

            ->add('prenom',\Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '200'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 200, 'minMessage' => 'Le prénom doit faire 2 caractères minimum ', 'maxMessage' => 'Le prénom dois faire 200 caractères maximum ']),
                    new Assert\NotBlank()
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '255'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Email(['message' => 'Veuillez entrer une adresse email valide.']),
                    new Assert\NotBlank()
                ]
            ])
            ->add('numeroTel', TelType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '15'
                ],
                'label' => 'Numéro de téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Regex(['pattern' => '/^\+?\d{0,15}$/', 'message' => 'Veuillez entrer un numéro de téléphone valide.']),
                    new Assert\NotBlank()
                ]
            ])
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer mon ingrédient'
            ])             
            ;           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
