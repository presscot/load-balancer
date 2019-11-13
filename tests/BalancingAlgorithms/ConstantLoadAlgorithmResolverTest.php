<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:36
 */

namespace Press\LoadBalancer\Tests\BalancingAlgorithms;

use InvalidArgumentException;
use Press\LoadBalancer\BalancingAlgorithms\ConstantLoadAlgorithmResolver;
use Press\LoadBalancer\Tests\HelperTrait;
use Press\LoadBalancer\Tests\MockerAbstract;
use Throwable;


class ConstantLoadAlgorithmResolverTest extends MockerAbstract
{
    public function testResolveWithEmptyArray(): void{

        $this->expectException(InvalidArgumentException::class);

        ( new ConstantLoadAlgorithmResolver() )->resolve([]);
    }

    public function testResolve(): void{
        try{
            ( new ConstantLoadAlgorithmResolver() )->resolve([ $this->getValidHostInstance() ]);
        }catch ( Throwable $e ){
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}