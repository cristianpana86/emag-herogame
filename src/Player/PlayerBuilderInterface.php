<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Player;


use CPANA\HeroGame\Helpers\Range;
use CPANA\HeroGame\Player\SkillInterface;

interface PlayerBuilderInterface
{
    public function getPlayer() : PlayerInterface;
    public function setPlayerType(string $playerType) : PlayerBuilderInterface;
    public function setHealth(Range $range) : PlayerBuilderInterface;
    public function setStrength(Range $range) : PlayerBuilderInterface;
    public function setDefence(Range $range) : PlayerBuilderInterface;
    public function setSpeed(Range $range) : PlayerBuilderInterface;
    public function setLuck(Range $range) : PlayerBuilderInterface;
    public function addAttackingSkill(SkillInterface $skill) : PlayerBuilderInterface;
    public function addDefensiveSkill(SkillInterface $skill) : PlayerBuilderInterface;
}