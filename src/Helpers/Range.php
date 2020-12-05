<?php
/**
 * @author: Cristian Pana
 * Date: 14.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Helpers;

/**
 * Class Range
 * @package CPANA\HeroGame\Helpers
 */
class Range
{
    /**
     * @var int
     */
    protected $lowerLimit;

    /**
     * @var int
     */
    protected $upperLimit;

    /**
     * Range constructor.
     * @param int $lowerLimit
     * @param int $upperLimit
     */
    public function __construct(int $lowerLimit, int $upperLimit)
    {
        $this->lowerLimit = $lowerLimit;
        $this->upperLimit = $upperLimit;
    }

    /**
     * @return mixed
     */
    public function getLowerLimit(): int
    {
        return $this->lowerLimit;
    }

    /**
     * @param mixed $lowerLimit
     */
    public function setLowerLimit(int $lowerLimit)
    {
        $this->lowerLimit = $lowerLimit;
    }

    /**
     * @return mixed
     */
    public function getUpperLimit(): int
    {
        return $this->upperLimit;
    }

    /**
     * @param mixed $upperLimit
     */
    public function setUpperLimit(int $upperLimit)
    {
        $this->upperLimit = $upperLimit;
    }


}