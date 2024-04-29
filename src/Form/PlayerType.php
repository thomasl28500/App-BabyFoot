<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('email', EmailType::class, [
            'label' => 'Adresse email',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez votre email'],
            'constraints' => [
                new NotBlank(['message' => 'L\'email est requis.']),
                new Email(['message' => 'Entrez une adresse email valide.'])
            ],
        ])
        ->add('roles', ChoiceType::class, [
            'label' => 'Rôles',
            'choices' => [
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER',
            ],
            'multiple' => true, // Permet de sélectionner plusieurs rôles
            'expanded' => true, // Affiche les choix sous forme de cases à cocher
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Mot de passe',
            'required' => false,
            'attr' => ['placeholder' => 'Entrez votre mot de passe'],
            'constraints' => [
                new NotBlank(['message' => 'Le mot de passe est requis.']),
                // Ajoutez d'autres contraintes de validation de mot de passe si nécessaire
            ],
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Nom de famille',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez votre nom de famille'],
            'constraints' => [
                new NotBlank(['message' => 'Le nom de famille est requis.']),
            ],
        ])
        ->add('firstName', TextType::class, [
            'label' => 'Prénom',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez votre prénom'],
            'constraints' => [
                new NotBlank(['message' => 'Le prénom est requis.']),
            ],
        ])
        ->add('nickName', TextType::class, [
            'label' => 'Surnom',
            'required' => false,
            'attr' => ['placeholder' => 'Entrez votre surnom (facultatif)'],
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
