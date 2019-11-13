<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 14:24
 */

declare(strict_types=1);

namespace Press\LoadBalancer\BalancingAlgorithms;

use Press\LoadBalancer\Interfaces\HostInstanceInterface;
use InvalidArgumentException;

/**
 * Class SequentialAlgorithmResolver
 * @package Press\LoadBalancer\BalancingAlgorithms
 */
class SequentialAlgorithmResolver implements BalancingAlgorithmResolverInterface
{
    private $n = -1;

    /**
     * @param HostInstanceInterface[] $hostInstances
     * @return HostInstanceInterface
     * @throws InvalidArgumentException
     */
    public function resolve(array $hostInstances): HostInstanceInterface
    {
        if( 0 >= count($hostInstances) ){
            throw new InvalidArgumentException("Array can not be empty");
        }

        return $hostInstances[ ++$this->n % count($hostInstances) ];
    }
}