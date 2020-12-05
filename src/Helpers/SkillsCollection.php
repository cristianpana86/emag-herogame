<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Helpers;

use CPANA\HeroGame\Player\SkillInterface;
use Doctrine\Common\Collections\ArrayCollection;

class SkillsCollection extends ArrayCollection
{
    public function add($element) : bool
    {
        if(!$element instanceof SkillInterface) {
            throw new \Exception("Type of element {$element} not compatible with SkillsInterface");
        }
        return parent::add($element);

    }

}