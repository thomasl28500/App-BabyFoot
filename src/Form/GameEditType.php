<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamBlueScore', IntegerType::class, [
                'label' => 'Score de l\'équipe bleue',
            ])
            ->add('teamRedScore', IntegerType::class, [
                'label' => 'Score de l\'équipe rouge',
            ])
            ->add('isFinish', ChoiceType::class, [
                'choices' => [
                    'Terminé' => true,
                    'En cours' => false,
                ],
                'label' => 'Statut du match',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
