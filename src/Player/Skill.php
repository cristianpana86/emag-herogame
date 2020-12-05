<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */

namespace CPANA\HeroGame\Player;


class Skill implements SkillInterface
{
    public $name;

    public $chancePercentage;

    /**
     * @param mixed $name
     */
    public function setName($name) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $chancePercentage
     */
    public function setChancePercentage($chancePercentage) : self
    {
        $this->chancePercentage = $chancePercentage;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getChancePercentage(): int
    {
        return $this->chancePercentage;
    }
}