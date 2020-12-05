<?php
/**
 * @author: Cristian Pana
 * Date: 16.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Game;


use CPANA\HeroGame\Event\AfterAttackEvent;
use CPANA\HeroGame\Event\DamageComputedEvent;
use CPANA\HeroGame\Helpers\LuckGenerator;
use CPANA\HeroGame\Helpers\Range;
use CPANA\HeroGame\Helpers\OutputInterface;
use CPANA\HeroGame\Player\Player;
use CPANA\HeroGame\Player\PlayerBuilder;
use CPANA\HeroGame\Player\PlayerBuilderInterface;
use CPANA\HeroGame\Player\PlayerInterface;
use CPANA\HeroGame\Player\Skill;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GameEngine implements GameEngineInterface
{
    /** @var EventDispatcher $dispatcher */
    protected $dispatcher;

    protected $maxRoundsCount;
    /** @var PlayerInterface $playerHero */
    protected $playerHero;
    /** @var PlayerInterface $playerHero */
    protected $playerBeast;

    protected $currentRound;
    protected $gameWinner;
    // After an attack, the players switch roles: the attacker now defends and the defender now attacks.
    /** @var PlayerInterface $attackingPlayer */
    protected $attackingPlayer;
    /** @var PlayerInterface $defendingPlayer */
    protected $defendingPlayer;

    /** @var OutputInterface $output */
    protected $output;

    /**
     * GameEngine constructor.
     * @param Container $container
     */
    public function __construct(OutputInterface $output, EventDispatcherInterface $dispatcher, PlayerBuilderInterface $playerBuilder, int $gameMaxRoundsCount, array $heroConfig, array $beastConfig)
    {
        $this->output           = $output;
        $this->dispatcher       = $dispatcher;
        $this->maxRoundsCount   = $gameMaxRoundsCount;
        $this->playerHero       = $this->initializePlayer(Player::PLAYER_HERO, $playerBuilder, $heroConfig);
        $this->playerBeast       = $this->initializePlayer(Player::PLAYER_BEAST, $playerBuilder, $beastConfig);
        $this->currentRound      = 1;
    }

    /**
     * Use PlayerBuilder fluent interface to create Player objects
     * @param $playerType
     * @param PlayerBuilderInterface $playerBuilder
     * @return PlayerInterface
     */
    protected function initializePlayer($playerType, PlayerBuilderInterface $playerBuilder, array $playerConfigArray)
    {
        $playerBuilder
            ->setPlayerType($playerType)
            ->setHealth(new Range(
                $playerConfigArray['health_lower_limit'],
                $playerConfigArray[ 'health_upper_limit']
            ))
            ->setStrength(new Range(
                $playerConfigArray[ 'strength_lower_limit'],
                $playerConfigArray[ 'strength_upper_limit']
            ))
            ->setDefence(new Range(
                $playerConfigArray[ 'defense_lower_limit'],
                $playerConfigArray[ 'defense_upper_limit']
            ))
            ->setSpeed(new Range(
                $playerConfigArray[ 'speed_lower_limit'],
                $playerConfigArray[ 'speed_upper_limit']
            ))
            ->setLuck(new Range(
                $playerConfigArray[ 'luck_lower_limit'],
                $playerConfigArray[ 'luck_upper_limit']
            ));

        // Add attacking skills
        if (isset($playerConfigArray['attacking_skills'])) {
            if (is_array($playerConfigArray['attacking_skills'])) {
                foreach ($playerConfigArray['attacking_skills'] as $name => $skillParams) {
                    $skill = new Skill();
                    $skill->setName($name);
                    foreach ($skillParams as $paramName => $value) {
                        $skill->{$paramName} = $value;
                    }
                    $playerBuilder->addAttackingSkill($skill);
                }
            }
        }

        // Add defending skills
        if (isset($playerConfigArray['defensive_skills'])) {
            if (is_array($playerConfigArray['defensive_skills'])) {
                foreach ($playerConfigArray['defensive_skills'] as $skillParams) {
                    $skill = new Skill();
                    $skill->setName($name);
                    foreach ($skillParams as $paramName => $value) {
                        $skill->{$paramName} = $value;
                    }
                    $playerBuilder->addDefensiveSkill($skill);
                }
            }
        }

        return  $playerBuilder->getPlayer();
    }


    /**
     * The game ends when one of the players remain without health or the number of turns(rounds) reaches 20.
     * @return bool
     */
    protected function isGameOver() : bool
    {
        // Check current turn(round)
        if($this->currentRound > $this->maxRoundsCount) {
            $this->output->error("End of the game by reaching maximum number of rounds!");
            return true;
        }
        // Check health, declare winner the other player
        if($this->playerHero->getHealth() <= 0) {
            $this->gameWinner = $this->playerBeast->getPlayerType();
            $this->output->error("End of the game, player {$this->playerHero->getPlayerType()} remained without health!");
            $this->output->error("Winner : {$this->gameWinner} ");
            return true;
        }
        if($this->playerBeast->getHealth() <= 0) {
            $this->gameWinner = $this->playerHero->getPlayerType();
            $this->output->error("End of the game, player {$this->playerBeast->getPlayerType()} remained without health!");
            $this->output->error("Winner : {$this->gameWinner} ");
            return true;
        }
        // Return false if conditions are not met
        return false;

    }

    /**
     * Before first round determine who is the first player to attack
     * The first attack is done by the player with the higher speed. If both players have the same speed,
     * than the attack is carried on by the player with the highest luck
     */
    protected function determineAttackingPlayer()
    {
        if($this->playerHero->getSpeed() === $this->playerBeast->getSpeed()) {
            if($this->playerHero->getLuck() > $this->playerBeast->getLuck()) {
                $this->attackingPlayer = $this->playerHero;
                $this->defendingPlayer = $this->playerBeast;
            } else {
                $this->attackingPlayer = $this->playerBeast;
                $this->defendingPlayer = $this->playerHero;
            }
            $this->output->message("First attacking player: {$this->attackingPlayer->getPlayerType()} with luck: {$this->attackingPlayer->getLuck()}");
            return;
        }
        if($this->playerHero->getSpeed() > $this->playerBeast->getSpeed()) {
            $this->attackingPlayer = $this->playerHero;
            $this->defendingPlayer = $this->playerBeast;
        } else {
            $this->attackingPlayer = $this->playerBeast;
            $this->defendingPlayer = $this->playerHero;
        }
        $this->output->message("First attacking player: {$this->attackingPlayer->getPlayerType()} with speed: {$this->attackingPlayer->getSpeed()}");

    }

    /**
     * Play the game
     * @return mixed
     */
    public function play()
    {
        $this->output->title("Game is on!");
        $this->output->title("Players initial stats: ");
        $this->output->message(strval($this->playerHero));
        $this->output->message(strval($this->playerBeast));


        // Determine who is attacking first
        $this->determineAttackingPlayer();

        while($this->isGameOver() !== true) {
            $this->playRound($this->attackingPlayer, $this->defendingPlayer);
            $this->currentRound++;
            // After an attack, the players switch roles: the attacker now defends and the defender now attacks.
            $temp = $this->defendingPlayer;
            $this->defendingPlayer = $this->attackingPlayer;
            $this->attackingPlayer = $temp;

        }
        $this->output->error("GAME OVER!");
    }

    /**
     * @param PlayerInterface $attackingPlayer
     * @param PlayerInterface $defendingPlayer
     */
    public function playRound(PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer)
    {
        $this->output->title("Current round: {$this->currentRound}");

        // TODO: dispatch before attack event

        $this->playAttack($attackingPlayer, $defendingPlayer);

        // Dispatch event "play_attack.after"
        $event = new AfterAttackEvent($this, $attackingPlayer, $defendingPlayer);
        $this->dispatcher->dispatch($event, AfterAttackEvent::NAME);

    }

    /**
     * The damage done by the attacker is calculated with the following formula:
     *      Damage = Attacker strength – Defender defence
     * The damage is subtracted from the defender’s health. An attacker can miss their hit and do no
     * damage if the defender gets lucky that turn.
     *
     * @param PlayerInterface $attackingPlayer
     * @param PlayerInterface $defendingPlayer
     */
    public function playAttack(PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer)
    {
        $isDefenderLucky = LuckGenerator::amILuckyOrWhat($defendingPlayer->getLuck());
        // Defender is lucky no damage is done
        if($isDefenderLucky) {
            $this->output->title("Defending player: {$defendingPlayer->getPlayerType()} was lucky! No damage occurred!");
            return;
        }
        $this->output->message("Attacking player: {$attackingPlayer->getPlayerType()} strength is: {$attackingPlayer->getStrength()}.");
        $this->output->message("Defending player: {$defendingPlayer->getPlayerType()} health is: {$defendingPlayer->getHealth()}.");

        if($attackingPlayer->getStrength() > $defendingPlayer->getHealth()) {
            $damage = new Damage();
            $damage->setValue($attackingPlayer->getStrength() - $defendingPlayer->getHealth());

            // Dispatch event damage.computed - any additional skills that may change damage output should be plugged
            // by listening to this event
            $event = new DamageComputedEvent($damage, $attackingPlayer, $defendingPlayer);
            $this->dispatcher->dispatch($event, DamageComputedEvent::NAME);

            $this->output->message("Defending player: {$defendingPlayer->getPlayerType()} suffered damage: {$damage->getValue()}!");

            // Apply damage to defending player
            $defendingPlayer->setHealth($defendingPlayer->getHealth() - $damage->getValue());

            $this->output->message("Defending player: {$defendingPlayer->getPlayerType()} health after damage: {$defendingPlayer->getHealth()}!");
        } else {
            $this->output->message("No damage occurred becasue defending health is bigger or equal with attacker's strength!");
        }

    }


}