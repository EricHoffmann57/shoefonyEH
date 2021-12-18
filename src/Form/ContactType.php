<?php

namespace App\Form;

Use App\Entity\Contact;
Use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
Use Symfony\Component\Form\Extension\Core\Type\TextType;
Use Symfony\Component\Form\Extension\Core\Type\EmailType;
Use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email'
            ])
            ->add('message', TextareaType::class,[
                    'label' => 'Message'
            ])
            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => contact::class,
        ]);
    }
}


