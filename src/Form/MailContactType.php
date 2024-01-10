<?php
namespace App\Form;

use App\Entity\MailContact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('object', TextType::class, [
                'label' => 'Objet',
            ])
            ->add('message', null, [
                'label' => 'Message',
            ])
        
            ->add('destinataires', EntityType::class, [
                'class' => 'App\Entity\Categorie', 
                'choice_label' => 'nomCategorie', 
                'label' => 'Destinataires',
                'multiple' => true,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailContact::class,
        ]);
    }
}