<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamBlue', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Votre équipe',
            ])
            ->add('teamRed', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe adverse',
            ])
            ->add('dateGame', null, [
                'widget' => 'single_text',
                'label' => 'Date du match',
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $game = $event->getData();
            if ($game instanceof Game) {
                $game->setTeamBlueScore(0);
                $game->setTeamRedScore(0);
                $game->setTeamWin(null);
                $game->setFinish(0);
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
