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

        $game = $builder->getData();

        $teamBlueName = $game->getTeamBlue() ? $game->getTeamBlue()->getName() : 'Équipe bleue';
        $teamRedName = $game->getTeamRed() ? $game->getTeamRed()->getName() : 'Équipe rouge';

        $builder
            ->add('teamBlueScore', IntegerType::class, [
                'label' => sprintf('Score de l\'équipe %s', $teamBlueName),
                'attr' => [
                    'min' => -10,
                    'max' => 10,
                ],
            ])
            ->add('teamRedScore', IntegerType::class, [
                'label' => sprintf('Score de l\'équipe %s', $teamRedName),
                'attr' => [
                    'min' => -10,
                    'max' => 10,
                ],
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
