<?php
/**
 * @author: Cristian Pana
 * Date: 19.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Game;


class Damage
{
    /** @var int */
    protected $value;

    public function __construct($value = 0)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value)
    {
        $this->value = $value;
    }
}