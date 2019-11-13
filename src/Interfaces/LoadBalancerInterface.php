<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:50
 */

declare(strict_types=1);

namespace Press\LoadBalancer\Interfaces;

use Press\LoadBalancer\TaskLimitations\LoadBalancerInterface as TaskLimitationsLoadBalancerInterface;

/**
 * Interface LoadBalancerInterface
 * @package Press\LoadBalancer\Interfaces
 */
interface LoadBalancerInterface extends TaskLimitationsLoadBalancerInterface
{
}