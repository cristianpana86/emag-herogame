<?php
/**
 * @author: Cristian Pana
 * Date: 14.10.2020
 */
declare(strict_types = 1);

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use CPANA\HeroGame\EventSubscriber\DamageComputedSubscriber;
use CPANA\HeroGame\EventSubscriber\AfterAttackSubscriber;
use CPANA\HeroGame\Game\GameEngine;
use CPANA\HeroGame\Helpers\OutputCLI;
use CPANA\HeroGame\Helpers\OutputHTML;
use CPANA\HeroGame\Player\PlayerBuilder;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

try {

    /* Read config file */
    $configFilePath = __DIR__ . '/config.php';
    if(is_file($configFilePath)) {
        $configArray = include $configFilePath;
    } else {
        throw new Exception("Cannot read config file from path: {$configFilePath}");
    }

    $container = new Container();

    // Add config params to container
    foreach ($configArray as $key => $value) {
        $container[$key] = $value;
    }

    // define services
    $container['player_builder'] = function ($container) {
        return new PlayerBuilder();
    };

    // Set Output service depending on how code is executed CLI/Web
    if(php_sapi_name() === 'cli') {
        $container['output'] = function ($container) {
            return new OutputCLI();
        };
    } else {
        $container['output'] = function ($container) {
            return new OutputHTML();
        };
    }

    $dispatcher = new EventDispatcher();

    // Implement magic shield skill in event subscriber
    $container['damage_computer_subscriber'] = function ($container) {
        return new DamageComputedSubscriber($container['output']);
    };
    $dispatcher->addSubscriber($container['damage_computer_subscriber']);

    // Implement rapid attack skill in event subscribers\
    $container['after_attack_subscriber'] = function ($container) {
        return new AfterAttackSubscriber($container['output']);
    };
    $dispatcher->addSubscriber($container['after_attack_subscriber']);

    $container['dispatcher'] = $dispatcher;

    // Create a GameEngine instance
    $game = new GameEngine( $container['output'],
                            $container['dispatcher'],
                            $container['player_builder'],
                            $container['GAME']['max_rounds_count'],
                            $container['HERO'],
                            $container['BEAST']
    );
    // Let's play the game
    $game->play();

} catch (Throwable $e) {
    // Save real error to logs, display generic message to users
    echo "There was an error. Please check logs!" . PHP_EOL;
    $message = $e->getMessage() . ' In file: ' . $e->getFile() . ' At line: ' . $e->getLine() . PHP_EOL;
    file_put_contents(__DIR__ .'/../logs/herogame.log', $message , FILE_APPEND );
}
