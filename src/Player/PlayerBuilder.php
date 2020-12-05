<?php
/**
 * @author: Cristian Pana
 * Date: 16.10.2020
 */

namespace CPANA\HeroGame\Player;


use CPANA\HeroGame\Helpers\Range;
use CPANA\HeroGame\Helpers\SkillsCollection;

/**
 * Class PlayerBuilder
 * The final scope of the PlayerBuilder is to create a Player object using the getPlayer() function
 * @package CPANA\HeroGame\Player
 */
class PlayerBuilder implements PlayerBuilderInterface
{
    protected $playerType;
    protected $health;
    protected $strength;
    protected $defence;
    protected $speed;
    protected $luck; // luck percentage
    protected $attackingSkillsCollection;
    protected $defensiveSkillsCollection;

    /**
     * PlayerBuilder constructor.
     */
    public function __construct()
    {
        $this->attackingSkillsCollection = new SkillsCollection();
        $this->defensiveSkillsCollection = new SkillsCollection();
    }

    /**
     * The final scope of the PlayerBuilder is to create Player object using the getPlayer() function
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        $player = new Player($this->playerType,
            $this->health,
            $this->strength,
            $this->defence,
            $this->speed,
            $this->luck,
            $this->attackingSkillsCollection,
            $this->defensiveSkillsCollection
        );
        // Implement reset mechanism
        $this->reset();

        return $player;
    }

    /**
     * Reset Builder
     */
    protected function reset()
    {
        unset($this->playerType);
        unset($this->health);
        unset($this->strength);
        unset($this->defence);
        unset($this->speed);
        unset($this->luck);
        unset($this->attackingSkillsCollection);
        $this->attackingSkillsCollection = new SkillsCollection();
        unset($this->defensiveSkillsCollection);
        $this->defensiveSkillsCollection = new SkillsCollection();
    }

    /**
     * @param string $playerType
     * @return PlayerBuilderInterface
     */
    public function setPlayerType(string $playerType): PlayerBuilderInterface
    {
        $this->playerType = $playerType;
        return$this;
    }


    /**
     * @param Range $range
     * @return PlayerBuilderInterface
     */
    public function setHealth(Range $range): PlayerBuilderInterface
    {
       $this->health = rand($range->getLowerLimit(), $range->getUpperLimit());
       return $this;
    }

    /**
     * @param Range $range
     * @return PlayerBuilderInterface
     */
    public function setStrength(Range $range): PlayerBuilderInterface
    {
        $this->strength = rand($range->getLowerLimit(), $range->getUpperLimit());
        return $this;
    }

    /**
     * @param Range $range
     * @return PlayerBuilderInterface
     */
    public function setDefence(Range $range): PlayerBuilderInterface
    {
        $this->defence = rand($range->getLowerLimit(), $range->getUpperLimit());
        return $this;
    }

    /**
     * @param Range $range
     * @return PlayerBuilderInterface
     */
    public function setSpeed(Range $range): PlayerBuilderInterface
    {
        $this->speed = rand($range->getLowerLimit(), $range->getUpperLimit());
        return $this;
    }

    /**
     * @param Range $range
     * @return PlayerBuilderInterface
     */
    public function setLuck(Range $range): PlayerBuilderInterface
    {
        $this->luck = rand($range->getLowerLimit(), $range->getUpperLimit());
        return $this;
    }

    /**
     * @param \CPANA\HeroGame\Player\SkillInterface $skill
     * @return PlayerBuilderInterface
     */
    public function addAttackingSkill(SkillInterface $skill): PlayerBuilderInterface
    {
        $this->attackingSkillsCollection->add($skill);
        return $this;
    }

    /**
     * @param \CPANA\HeroGame\Player\SkillInterface $skill
     * @return PlayerBuilderInterface
     */
    public function addDefensiveSkill(SkillInterface $skill): PlayerBuilderInterface
    {
        $this->defensiveSkillsCollection->add($skill);
        return $this;
    }


}