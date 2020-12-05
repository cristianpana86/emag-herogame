<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Event;

use CPANA\HeroGame\Game\Damage;
use CPANA\HeroGame\Player\PlayerInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The damage.computed event is dispatched each time an damage occurs and is computed in playAttack() function
 *
 */
class DamageComputedEvent extends Event
{
    public const NAME = 'damage.computed';

    /** @var Damage  */
    protected $damage;

    protected $attackingPlayer;

    protected $defendingPlayer;

    public function __construct(Damage $damage, PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer)
    {
        $this->damage = $damage;
        $this->attackingPlayer = $attackingPlayer;
        $this->defendingPlayer = $defendingPlayer;
    }

    public function getDamage() : Damage
    {
        return $this->damage;
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
