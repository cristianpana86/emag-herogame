<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */
declare(strict_types = 1);


namespace CPANA\HeroGame\EventSubscriber;

use CPANA\HeroGame\Event\DamageComputedEvent;
use CPANA\HeroGame\Game\Damage;
use CPANA\HeroGame\Helpers\LuckGenerator;
use CPANA\HeroGame\Helpers\OutputInterface;
use CPANA\HeroGame\Player\PlayerInterface;
use CPANA\HeroGame\Player\SkillInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Special skill Magic Shield implemented as an event subscriber to event: 'damage.computed'
 *
 * Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20%
change he’ll use this skill every time he defends
 * Class MagicShieldSkillSubscriber
 * @package CPANA\HeroGame\Player
 */
class DamageComputedSubscriber implements EventSubscriberInterface
{
    public const MAGIC_SHIELD = 'magic_shield';
    public const DUMMY_SHIELD = 'dummy_shield';

    protected $output;


    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    public static function getSubscribedEvents()
    {
        return [
            DamageComputedEvent::NAME => [
                ['magicShieldSkill', 10],
                ['dummyShieldSkill', 0],
            ],
        ];
    }

    /**
     * Implement Magic shield skill
     *  Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20%
     *  change he’ll use this skill every time he defends
     * @param DamageComputedEvent $event
     */
    public function magicShieldSkill(DamageComputedEvent $event)
    {
        /** @var PlayerInterface $defendingPlayer */
        $defendingPlayer = $event->getDefendingPlayer();
        // If defending player has this skill it will be applied
        if($defendingPlayer->hasSkillWithName(DamageComputedSubscriber::MAGIC_SHIELD)){
            $skill = $defendingPlayer->getSkillByName(DamageComputedSubscriber::MAGIC_SHIELD);

            if(LuckGenerator::amILuckyOrWhat($skill->getChancePercentage())) {
                $this->output->error("Magic shield skill is applied by defending player: {$defendingPlayer->getPlayerType()}");
                /** @var Damage $damage */
                $damage = $event->getDamage();
                $this->output->message("Computed damage before applying Magic Skill {$damage->getValue()}");
                $damage->setValue(intval($damage->getValue() / 2));
                // Just for testing purpose
                return $damage;
            } else {
                $this->output->error("Unlucky defending player {$defendingPlayer->getPlayerType()} was not able to use skill {$skill->getName()} due to bad luck");
            }
        }
    }

    /**
     * Implement dummy shield skill just for demo purpose
     * @param DamageComputedEvent $event
     */
    public function dummyShieldSkill(DamageComputedEvent $event)
    {
        /** @var PlayerInterface $defendingPlayer */
        $defendingPlayer = $event->getDefendingPlayer();
        // If defending player has this skill it will be applied
        if($defendingPlayer->hasSkillWithName(DamageComputedSubscriber::DUMMY_SHIELD)){
            $skill = $defendingPlayer->getSkillByName(DamageComputedSubscriber::DUMMY_SHIELD);
            if(LuckGenerator::amILuckyOrWhat($skill->getChancePercentage())) {
                $this->output->error("Dummy shield skill is applied by defending player: {$defendingPlayer->getPlayerType()} but it was no real power");
                // Implement actual behavior here

            } else {
                $this->output->error("Unlucky defending player {$defendingPlayer->getPlayerType()} was not able to use skill {$skill->getName()} due to bad luck");
            }
        }
    }
}