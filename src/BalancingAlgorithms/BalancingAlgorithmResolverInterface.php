<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 14:23
 */

declare(strict_types=1);

namespace Press\LoadBalancer\BalancingAlgorithms;

use Press\LoadBalancer\Interfaces\HostInstanceInterface;

/**
 * Interface BalancingAlgorithmResolverInterface
 * @package Press\LoadBalancer\BalancingAlgorithms
 */
interface BalancingAlgorithmResolverInterface
{
    /**
     * @param HostInstanceInterface[] $hostInstances
     * @return HostInstanceInterface
     */
    public function resolve(array $hostInstances ): HostInstanceInterface;
}