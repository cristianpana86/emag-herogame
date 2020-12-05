<?php
/**
 * @author: Cristian Pana
 * Date: 15.10.2020
 */

namespace CPANA\HeroGame\Helpers;


interface OutputInterface
{
    public function message(string $value);
    public function title(string $value);
    public function error(string $value);
}