<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:22
 */

declare(strict_types=1);

namespace Press\LoadBalancer\Tests;

use Press\LoadBalancer\BalancingAlgorithms\{ConstantLoadAlgorithmResolver,SequentialAlgorithmResolver};
use Press\LoadBalancer\LoadBalancer;
use Press\LoadBalancer\TaskLimitations\LoadBalancerInterface;
use InvalidArgumentException;
use LengthException;
use Throwable;

class LoadBalancerTest extends MockerAbstract
{
    public function testLoadBalancerValidTaskLimitations(): void{
        $this->assertInstanceOf(
            LoadBalancerInterface::class,
            new LoadBalancer([$this->getValidHostInstance() ], new SequentialAlgorithmResolver() )
        );
    }

    public function testCanBeCreatedWithStringHost(): void{
        $this->assertInstanceOf(
            LoadBalancerInterface::class,
            new LoadBalancer([$this->getUrl() ], new SequentialAlgorithmResolver() )
        );
    }

    public function testCannotBeCreatedWithEmptyHostList(): void{

        $this->expectException(LengthException::class);

        new LoadBalancer([], new SequentialAlgorithmResolver() );
    }

    public function testCannotBeCreatedWithNoInstanceHostAndStringType(): void{

        $this->expectException(InvalidArgumentException::class);

        new LoadBalancer([1], new SequentialAlgorithmResolver() );
    }

    public function testCannotBeCreatedWithMixedArguments(): void{

        $this->expectException(InvalidArgumentException::class);

        new LoadBalancer([$this->getValidHostInstance(), $this->getUrl()], new SequentialAlgorithmResolver() );
    }

    public function testHandleRequestWithSequentialAlgorithmResolver(): void{
        try{
            $loadBalancer = new LoadBalancer([$this->getUrl()], new SequentialAlgorithmResolver() );
            $loadBalancer->handleRequest($this->getValidRequest());
        }catch ( Throwable $e ){
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function testHandleRequestWithConstantLoadAlgorithmResolver(): void{
        try{
            $loadBalancer = new LoadBalancer([$this->getUrl()], new ConstantLoadAlgorithmResolver() );
            $loadBalancer->handleRequest($this->getValidRequest());
        }catch ( Throwable $e ){
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}