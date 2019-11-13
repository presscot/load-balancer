<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:50
 */

declare(strict_types=1);

namespace Press\LoadBalancer\TaskLimitations;

use Press\LoadBalancer\BalancingAlgorithms\BalancingAlgorithmResolverInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Interface LoadBalancerInterface
 * @package Press\LoadBalancer\TaskLimitations
 */
interface LoadBalancerInterface
{
    /**
     * LoadBalancer constructor.
     * @param string[]|HostInstanceInterface[] $hostInstances
     * @param BalancingAlgorithmResolverInterface|null $balancingAlgorithm
     */
    public function __construct(array $hostInstances, ?BalancingAlgorithmResolverInterface $balancingAlgorithm );

    /**
     * @param RequestInterface $request
     */
    public function handleRequest(RequestInterface $request): void;
}