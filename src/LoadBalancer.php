<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:42
 */

declare(strict_types=1);

namespace Press\LoadBalancer;

use Press\LoadBalancer\BalancingAlgorithms\BalancingAlgorithmResolverInterface;
use Press\LoadBalancer\BalancingAlgorithms\SequentialAlgorithmResolver;
use Press\LoadBalancer\Interfaces\HostInstanceInterface;
use Press\LoadBalancer\Interfaces\LoadBalancerInterface;
use Psr\Http\Message\RequestInterface;

use InvalidArgumentException;
use LengthException;

/**
 * Class LoadBalancer
 * @package Press\LoadBalancer
 */
final class LoadBalancer implements LoadBalancerInterface
{

    /** @var BalancingAlgorithmResolverInterface $balancingAlgorithmResolver */
    private $balancingAlgorithmResolver;

    /** @var HostInstanceInterface[] $hostInstances  */
    private $hostInstances;

    /**
     * LoadBalancer constructor.
     * @param string[]|HostInstanceInterface[] $hostInstances
     * @param BalancingAlgorithmResolverInterface|null $balancingAlgorithmResolver
     * @throws InvalidArgumentException
     * @throws LengthException
     */
    public function __construct(array $hostInstances, ?BalancingAlgorithmResolverInterface $balancingAlgorithmResolver )
    {
        $this->hostInstances = $this->validateHostInstancesArray($hostInstances);
        $this->balancingAlgorithmResolver = $balancingAlgorithmResolver ?? new SequentialAlgorithmResolver();
    }

    /**
     * @param RequestInterface $request
     */
    public function handleRequest(RequestInterface $request): void{
        $hostInstance = $this->balancingAlgorithmResolver->resolve($this->hostInstances);
        $hostInstance->handleRequest($request);
    }

    /**
     * @param string[]|HostInstanceInterface[] $hostInstances
     * @return HostInstanceInterface[]
     * @throws InvalidArgumentException
     * @throws LengthException
     */
    private function validateHostInstancesArray(array $hostInstances): array{

        if( 0 >= count( $hostInstances ) ){
            throw new LengthException("List of hosts can not be empty");
        }

        switch (true){
            /** @noinspection PhpMissingBreakStatementInspection */
            case is_string($hostInstances[0]):
                $hostInstances = array_map(
                    function(string $hostInstance){
                        return new HostInstance($hostInstance);
                    }, $hostInstances
                );
            case $this->isArrayOfType($hostInstances, HostInstanceInterface::class ):
                return $hostInstances;
                break;
            default:
                throw new InvalidArgumentException("Elements of array should be type of string or HostInstanceInterface");
        }
    }

    /**
     * @param array $array
     * @param string $type
     * @return bool
     */
    private function isArrayOfType(array $array, string $type): bool {
        foreach($array as $value){
            if( !( $value instanceof $type ) ){
                return false;
            }
        }

        return true;
    }
}
