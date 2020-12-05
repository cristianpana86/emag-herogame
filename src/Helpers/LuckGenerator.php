<?php
/**
 * @author: Cristian Pana
 * Date: 14.10.2020
 */
declare(strict_types = 1);

namespace CPANA\HeroGame\Helpers;

/**
 * Class LuckGenerator
 * @package CPANA\HeroGame\Helpers
 */
class LuckGenerator
{
    /**
     * Determine if lucky or not  (0% means no luck, 100% lucky all the time)
     * @param int $luckPercentage - a percentage as luck probability value.
     * @return bool
     */
    public static function amILuckyOrWhat(int $luckPercentage): bool
    {
        if ($luckPercentage === 0) {
            return false;
        } elseif ($luckPercentage === 100) {
            return true;
        } elseif ($luckPercentage < 0 and $luckPercentage > 100) {
            throw new \Exception("Invalid luck percentage value: {$luckPercentage}!");
        } else {
            // Based on $luckPercentage return true or false
            $value = rand(0,100);
            if($value <= $luckPercentage) {
                return true;
            } else {
                return false;
            }
        }
    }
}