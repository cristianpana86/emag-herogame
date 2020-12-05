<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */
declare(strict_types = 1);


namespace CPANA\HeroGame\EventSubscriber;

use CPANA\HeroGame\Event\AfterAttackEvent;
use CPANA\HeroGame\Event\DamageComputedEvent;
use CPANA\HeroGame\Game\Damage;
use CPANA\HeroGame\Game\GameEngine;
use CPANA\HeroGame\Helpers\LuckGenerator;
use CPANA\HeroGame\Helpers\OutputInterface;
use CPANA\HeroGame\Player\PlayerInterface;
use CPANA\HeroGame\Player\SkillInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Implement Rapid strike skill as an event subscriber to event: 'damage.computed'
 *
 * @package CPANA\HeroGame\Player
 */
class AfterAttackSubscriber implements EventSubscriberInterface
{
    public const RAPID_STRIKE = 'rapid_strike';
    public const DUMMY_STRIKE = 'dummy_strike';

    protected $output;


    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    public static function getSubscribedEvents()
    {
        return [
            AfterAttackEvent::NAME => [
                ['rapidStrikeSkill', 10],
                ['dummyStrikeSkill', 0]
            ],
        ];
    }

    /**
     * Implement Rapid strike skill
     * Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill
     * every time he attacks
     * @param AfterAttackEvent $event
     */
    public function rapidStrikeSkill(AfterAttackEvent $event)
    {
        /** @var GameEngine $gameEngine */
        $gameEngine = $event->getGameEngine();

        /** @var PlayerInterface $defendingPlayer */
        $defendingPlayer = $event->getDefendingPlayer();

        /** @var PlayerInterface $attackingPlayer */
        $attackingPlayer = $event->getAttackingPlayer();

        // If defending player has this skill it will be applied
        if($attackingPlayer->hasSkillWithName(AfterAttackSubscriber::RAPID_STRIKE)){
            $skill = $attackingPlayer->getSkillByName(AfterAttackSubscriber::RAPID_STRIKE);

            if(LuckGenerator::amILuckyOrWhat($skill->getChancePercentage())) {
                $this->output->error("Rapid skill is used by attacking player: {$attackingPlayer->getPlayerType()} to launch a second attack per round");
                $gameEngine->playAttack($attackingPlayer, $defendingPlayer);
            } else {
                $this->output->error("Unlucky attacking player {$attackingPlayer->getPlayerType()} was not able to use his skill {$skill->getName()} due to bad luck");
            }
        }
    }

    /**
     * Implement another Dummy skill for demonstration purpose
     * @param AfterAttackEvent $event
     */
    public function dummyStrikeSkill(AfterAttackEvent $event)
    {
        /** @var PlayerInterface $attackingPlayer */
        $attackingPlayer = $event->getAttackingPlayer();

        // If defending player has this skill it will be applied
        if($attackingPlayer->hasSkillWithName(AfterAttackSubscriber::DUMMY_STRIKE)){
            $skill = $attackingPlayer->getSkillByName(AfterAttackSubscriber::DUMMY_STRIKE);
            if(LuckGenerator::amILuckyOrWhat($skill->getChancePercentage())) {
                $this->output->error("Silly dummy skill is used by attacking player: {$attackingPlayer->getPlayerType()} but it has no real power");
                // Implement actual behavior here
            } else {
                $this->output->error("Unlucky attacking player {$attackingPlayer->getPlayerType()} was not able to use his skill {$skill->getName()} due to bad luck");
            }
        }
    }
}
