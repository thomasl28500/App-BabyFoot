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
use App\Repository\TeamRepository;
use App\Validator\DateMatch;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('teamBlue', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'query_builder' => function (TeamRepository $repository) use ($user) { //Liste des équipes du joueur connecté
                    return $repository->createQueryBuilder('t')
                        ->join('t.teamCompositions', 'tc')
                        ->where('tc.idPlayer = :user')
                        ->setParameter('user', $user);
                },
                'label' => 'Votre équipe',
            ])
            ->add('teamRed', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe adverse *',
                'query_builder' => function (TeamRepository $repository) use ($user) { //Liste des équipes qui ne sont pas au joueur connecté
                    return $repository->createQueryBuilder('t')
                        ->join('t.teamCompositions', 'tc')
                        ->where('tc.idPlayer != :user')
                        ->setParameter('user', $user)
                        ->groupBy('t.id')
                        ->having('COUNT(tc.idPlayer) = 2 AND SUM(CASE WHEN tc.idPlayer = :user THEN 1 ELSE 0 END) = 0');
                    },
            ])
            ->add('dateGame', null, [
                'widget' => 'single_text',
                'label' => 'Date du Match',
                'constraints' => [
                    new DateMatch(),
                ],
            ]);

        // EventListener pour les valeurs par défaut du formulaire
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
            'user' => null,
        ]);
    }
}
