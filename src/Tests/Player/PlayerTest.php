<?php
/**
 * @author: Cristian Pana
 * Date: 20.10.2020
 */
declare(strict_types=1);

namespace CPANA\HeroGame\Tests\Player;

use CPANA\HeroGame\Helpers\SkillsCollection;
use CPANA\HeroGame\Player\Player;
use CPANA\HeroGame\Player\PlayerInterface;
use CPANA\HeroGame\Player\Skill;
use CPANA\HeroGame\Player\SkillInterface;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /** @var  PlayerInterface $player */
    private $player;
    /** @var  SkillInterface $skillX */
    private $skillX;
    /** @var  SkillInterface $skillY */
    private $skillY;

    protected function setUp() : void
    {
        $this->player = new Player(Player::PLAYER_BEAST,
            80,
            70,
            60,
            60,
            60,
             new SkillsCollection(),
             new SkillsCollection()
        );
        $this->skillX = new Skill();
        $this->skillX->setName('skillX')->setChancePercentage(20);
        $this->skillY = new Skill();
        $this->skillY->setName('skillY')->setChancePercentage(20);
        $this->player->addAttackingSkills($this->skillX);
        $this->player->addDefensiveSkills($this->skillY);
    }

    protected function tearDown() : void
    {
        $this->player = NULL;
    }

    public function testhasAttackingSkillWithName()
    {
        $result = $this->player->hasSkillWithName($this->skillX->getName());
        $this->assertEquals(true, $result);
    }

    public function testhasDefensiveSkillWithName()
    {
        $result = $this->player->hasSkillWithName($this->skillY->getName());
        $this->assertEquals(true, $result);
    }

    public function testdoesNotHaveSkillWithName()
    {
        $result = $this->player->hasSkillWithName('unknownSkill');
        $this->assertEquals(false, $result);
    }


}