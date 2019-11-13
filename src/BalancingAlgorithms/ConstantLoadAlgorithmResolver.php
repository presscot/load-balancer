<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 15:22
 */

declare(strict_types=1);

namespace Press\LoadBalancer\BalancingAlgorithms;

use Press\LoadBalancer\Interfaces\HostInstanceInterface;

use InvalidArgumentException;

/**
 * Class ConstantLoadAlgorithmResolver
 * @package Press\LoadBalancer\BalancingAlgorithms
 */
class ConstantLoadAlgorithmResolver implements BalancingAlgorithmResolverInterface
{
    /** @var float $constant */
    private $constant;

    /**
     * ConstantLoadAlgorithmResolver constructor.
     * @param float $constant
     */
    public function __construct(float $constant = 0.75)
    {
        $this->constant = $constant;
    }

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

        $candidate = $hostInstances[0];

        foreach ($hostInstances as $hostInstance ){
            if( $this->constant > $hostInstance->getLoad() ){
                return $hostInstance;
            }

            if( $candidate->getLoad() > $hostInstance->getLoad()  ){
                $candidate = $hostInstance;
            }
        }

        return $candidate;
    }
}