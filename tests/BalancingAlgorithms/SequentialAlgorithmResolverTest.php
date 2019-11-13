<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:36
 */

namespace Press\LoadBalancer\Tests\BalancingAlgorithms;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Press\LoadBalancer\BalancingAlgorithms\SequentialAlgorithmResolver;
use Press\LoadBalancer\Tests\HelperTrait;
use Throwable;

class SequentialAlgorithmResolverTest extends TestCase
{
    use HelperTrait;

    public function testResolveWithEmptyArray(): void{

        $this->expectException(InvalidArgumentException::class);

        ( new SequentialAlgorithmResolver() )->resolve([]);
    }

    public function testResolveReturnDifferentObjectBiggerThanOneArray(): void{

        $list = [$this->getValidHostInstance(), $this->getValidHostInstance()];

        $sequentialAlgorithmResolver = new SequentialAlgorithmResolver();
        $host1 = $sequentialAlgorithmResolver->resolve($list);
        $host2 = $sequentialAlgorithmResolver->resolve($list);

        $this->assertNotSame($host1 , $host2);
    }

    public function testResolve(): void{
        try{
            ( new SequentialAlgorithmResolver() )->resolve([ $this->getValidHostInstance() ]);
        }catch ( Throwable $e ){
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}