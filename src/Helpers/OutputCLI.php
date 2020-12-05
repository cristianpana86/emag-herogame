<?php
/**
 * @author: Cristian Pana
 * Date: 16.10.2020
 */

namespace CPANA\HeroGame\Helpers;


use CPANA\HeroGame\Helpers\OutputInterface;

/**
 * See more info about console formatting: http://blog.lenss.nl/2012/05/adding-colors-to-php-cli-script-output/
 * Class OutputCLI
 * @package CPANA\HeroGame\Helpers
 */
class OutputCLI implements OutputInterface
{
    /**
     * @param string $value
     * @return mixed
     */
    public function message(string $value)
    {
        echo "\033[37m {$value} \033[0m" . PHP_EOL;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function title(string $value)
    {
        echo "\033[4m {$value}	\033[0m " . PHP_EOL;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function error(string $value)
    {
        echo "\033[31m {$value} \033[0m" . PHP_EOL;
    }


}