<?php
/**
 * @author: Cristian Pana
 * Date: 20.10.2020
 */

namespace CPANA\HeroGame\Tests\EventSubscriber;

use CPANA\HeroGame\Event\DamageComputedEvent;
use CPANA\HeroGame\EventSubscriber\DamageComputedSubscriber;
use CPANA\HeroGame\Game\Damage;
use CPANA\HeroGame\Helpers\OutputCLI;
use CPANA\HeroGame\Player\Player;
use CPANA\HeroGame\Player\PlayerInterface;
use CPANA\HeroGame\Player\Skill;
use PHPUnit\Framework\TestCase;

class DamageComputedSubscriberTest extends TestCase
{
    protected $event;


    public function testmagicShield()
    {
        // Stub skill
        $stubSkill = $this->createStub(Skill::class);
        $stubSkill->method('getName')
            ->willReturn(DamageComputedSubscriber::MAGIC_SHIELD);
        $stubSkill->method('getChancePercentage')
            ->willReturn(100);

        // Create a stub for the Player class.
        $stubDefendingPlayer = $this->createStub(Player::class);
        $stubDefendingPlayer->method('hasSkillWithName')
            ->willReturn(true);
        $stubDefendingPlayer->method('getSkillByName')
            ->willReturn($stubSkill);

        // Stub Damage
        $damage = new Damage();
        $damage->setValue(10);

        // Stub Event
        $stubEvent = $this->createStub(DamageComputedEvent::class);
        $stubEvent->method('getDefendingPlayer')
            ->willReturn($stubDefendingPlayer);
        $stubEvent->method('getDamage')
            ->willReturn($damage);

        $damageComputedSubscriber = new DamageComputedSubscriber($this->createStub(OutputCLI::class));


        $damageComputedSubscriber->magicShieldSkill($stubEvent);

        $this->assertSame(5, $damage->getValue());
    }
}