<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Player;

use CPANA\HeroGame\Helpers\SkillsCollection;
use Doctrine\Common\Collections\ArrayCollection;
use SebastianBergmann\CodeCoverage\Report\PHP;

class Player implements PlayerInterface
{
    const PLAYER_HERO = "HERO";
    const PLAYER_BEAST = "BEAST";

    protected $playerType;
    protected $health;
    protected $strength;
    protected $defence;
    protected $speed;
    protected $luck;

    /** @var SkillsCollection  $attackingSkills */
    protected $attackingSkills;
    /** @var SkillsCollection  $defensiveSkills */
    protected $defensiveSkills;

    /**
     * Player constructor.
     * @param string $playerType
     * @param int $health
     * @param int $strength
     * @param int $defence
     * @param int $speed
     * @param int $luck
     * @param SkillsCollection $attackingSkills
     * @param SkillsCollection $defensiveSkills
     */
    public function __construct(string $playerType,
                                int $health,
                                int $strength,
                                int $defence,
                                int $speed,
                                int $luck,
                                SkillsCollection $attackingSkills,
                                SkillsCollection $defensiveSkills
    )
    {
        $this->playerType       = $playerType;
        $this->health           = $health;
        $this->strength         = $strength;
        $this->defence          = $defence;
        $this->speed            = $speed;
        $this->luck             = $luck;
        $this->attackingSkills  = $attackingSkills;
        $this->defensiveSkills  = $defensiveSkills;
    }

    /**
     * @param string $playerType
     * @return mixed
     */
    public function setPlayerType(string $playerType)
    {
        $this->playerType = $playerType;
    }

    /**
     * @return string
     */
    public function getPlayerType(): string
    {
        return $this->playerType;
    }


    public function setHealth(int $value)
    {
        $this->health = $value;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setStrength(int $value)
    {
        $this->strength = $value;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setDefence(int $value)
    {
        $this->defence = $value;
    }

    public function getDefence(): int
    {
       return $this->defence;
    }

    public function setSpeed(int $value)
    {
        $this->speed = $value;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setLuck(int $value)
    {
        $this->luck = $value;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    /**
     * @return SkillsCollection
     */
    public function getAttackingSkills(): SkillsCollection
    {
        return $this->attackingSkills;
    }

    /**
     * @param SkillInterface $skill
     * @return SkillsCollection
     */
    public function addAttackingSkills(SkillInterface $skill) : SkillsCollection
    {
        $this->attackingSkills->add($skill);
        return $this->attackingSkills;
    }

    /**
     * @return SkillsCollection
     */
    public function getDefensiveSkills(): SkillsCollection
    {
        return $this->defensiveSkills;
    }

    /**
     * @param SkillInterface $skill
     * @return SkillsCollection
     */
    public function addDefensiveSkills(SkillInterface $skill): SkillsCollection
    {
        $this->defensiveSkills->add($skill);
        return $this->defensiveSkills;
    }

    /**
     * Check if player has certain skill
     * @param SkillInterface $skill
     * @return bool
     */
    public function hasSkill(SkillInterface $skill) : bool
    {
        if($this->defensiveSkills->contains($skill) or
            $this->attackingSkills->contains($skill)
        ) {
            return true;
        }
        return false;
    }

    /**
     * Check if player has a certain skill by skill name
     * @param string $skillName
     * @return bool
     */
    public function hasSkillWithName(string $skillName) : bool
    {
        /** @var SkillInterface $skill */
        foreach ($this->defensiveSkills as $skill) {
            if($skill->getName() === $skillName) return true;
        }

        foreach ($this->attackingSkills as $skill) {
            if($skill->getName() === $skillName) return true;
        }
        return false;
    }

    /**
     * Get actual Skill object by name
     * @param string $skillName
     * @return SkillInterface|null
     */
    public function getSkillByName(string $skillName) : ?SkillInterface
    {
        /** @var SkillInterface $skill */
        foreach ($this->defensiveSkills as $skill) {
            if($skill->getName() === $skillName) return $skill;
        }

        foreach ($this->attackingSkills as $skill) {
            if($skill->getName() === $skillName) return $skill;
        }
        return null;
    }

    public function __toString() : string
    {
        $string  = "Player type: {$this->playerType}".PHP_EOL;
        $string .= "Health:      {$this->health}".PHP_EOL;
        $string .= "Strength:    {$this->strength}".PHP_EOL;
        $string .= "Defence:     {$this->defence}".PHP_EOL;
        $string .= "Speed:       {$this->speed}".PHP_EOL;
        $string .= "Luck:        {$this->luck}".PHP_EOL;

        $attackingSkills = '';
        foreach ($this->attackingSkills as $skill) {
            /** @var Skill $skill */
            $attackingSkills .= $skill->getName() . ' ';
        }
        $defensiveSkills = '';
        foreach ($this->defensiveSkills as $skill) {
            /** @var Skill $skill */
            $defensiveSkills .= $skill->getName() . ' ';
        }

        $string .= "Attacking skills:  {$attackingSkills}".PHP_EOL;
        $string .= "Defensive skills:  {$defensiveSkills}".PHP_EOL;

        return $string;
    }
}