<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 15:15
 */

declare(strict_types=1);

(static function () {
    if (!is_file($autoloadFile = __DIR__ . '/../vendor/autoload.php')) {
        throw new RuntimeException('Did not find vendor/autoload.php.');
    }
    $loader = require $autoloadFile;
    $loader->add('Press\LoadBalancer\Tests', __DIR__);

})();