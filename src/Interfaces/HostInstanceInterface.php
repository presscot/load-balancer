<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:50
 */

declare(strict_types=1);

namespace Press\LoadBalancer\Interfaces;

use Press\LoadBalancer\TaskLimitations\HostInstanceInterface as TaskLimitationsHostInstanceInterface;

/**
 * Interface HostInstanceInterface
 * @package Press\LoadBalancer\Interfaces
 */
interface HostInstanceInterface extends TaskLimitationsHostInstanceInterface
{
    const LOAD_DIV = 5;
}