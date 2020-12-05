<?php
/**
 * @author: Cristian Pana
 * Date: 16.10.2020
 */

namespace CPANA\HeroGame\Helpers;


use CPANA\HeroGame\Helpers\OutputInterface;

/**
 * Class OutputHTML
 * @package CPANA\HeroGame\Helpers
 */
class OutputHTML implements OutputInterface
{
    /**
     * @param string $value
     * @return mixed
     */
    public function message(string $value)
    {
        echo "<p>{$value}</p>";
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function title(string $value)
    {
        echo "<h3>{$value}</h3>";
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function error(string $value)
    {
        echo "<p><span style='color: red'>{$value}</span></p>";
    }


}