<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Player;


interface SkillInterface
{
    public function getName() : string;
    public function getChancePercentage() : int;
}