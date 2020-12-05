<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Player;


use CPANA\HeroGame\Helpers\SkillsCollection;

interface PlayerInterface
{
    public function setPlayerType(string $playerType);
    public function getPlayerType() : string;
    public function setHealth(int $value);
    public function getHealth() : int;
    public function setStrength(int $value);
    public function getStrength() : int;
    public function setDefence(int $value);
    public function getDefence() : int;
    public function setSpeed(int $value);
    public function getSpeed() : int;
    public function setLuck(int $value);
    public function getLuck() : int;
    public function getAttackingSkills() : SkillsCollection;
    public function getDefensiveSkills() : SkillsCollection;
    public function hasSkill(SkillInterface $skill) : bool;
    public function hasSkillWithName(string $skillName) : bool;
    public function getSkillByName(string $skillName) : ?SkillInterface;
}