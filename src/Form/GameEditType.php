<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
            ]);
            // ->add('isFinish', ChoiceType::class, [
            //     'choices' => [
            //         'En cours' => false,
            //         'Terminé' => true,
            //     ],
            //     'label' => 'Statut du match',
            // ]);

            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $game = $event->getData();
                if ($game instanceof Game) {
                    $game->setFinish(1);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
