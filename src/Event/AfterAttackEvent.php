<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Event;

use CPANA\HeroGame\Game\GameEngineInterface;
use CPANA\HeroGame\Player\PlayerInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The "play_attack.after" event is dispatched after playAttack() function is called
 *
 */
class AfterAttackEvent extends Event
{
    public const NAME = 'play_attack.after';

    protected $gameEngine;

    protected $attackingPlayer;

    protected $defendingPlayer;


    public function __construct(GameEngineInterface $gameEngine, PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer)
    {
        $this->gameEngine = $gameEngine;
        $this->attackingPlayer = $attackingPlayer;
        $this->defendingPlayer = $defendingPlayer;
    }

    public function getGameEngine() : GameEngineInterface
    {
        return $this->gameEngine;
    }

    /**
     * @return PlayerInterface
     */
    public function getAttackingPlayer(): PlayerInterface
    {
        return $this->attackingPlayer;
    }

    /**
     * @return PlayerInterface
     */
    public function getDefendingPlayer(): PlayerInterface
    {
        return $this->defendingPlayer;
    }

}
