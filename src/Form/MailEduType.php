<?php
namespace App\Form;

use App\Entity\MailEdu;
use App\Entity\Educateur; // Ajoutez l'importation de l'entité Educateur
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailEduType extends AbstractType
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
                'class' => Educateur::class, 
                'choice_label' => 'email', 
                'multiple' => true,
                'required' => false,
                'label' => 'Destinataires',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailEdu::class,
        ]);
    }
}
