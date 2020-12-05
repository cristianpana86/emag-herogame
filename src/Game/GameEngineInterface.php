<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Game;

use CPANA\HeroGame\Player\PlayerInterface;
use Pimple\Container;

interface GameEngineInterface
{
    public function play();
    public function playRound(PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer);
    public function playAttack(PlayerInterface $attackingPlayer, PlayerInterface $defendingPlayer);
}