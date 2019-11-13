<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:22
 */

namespace Press\LoadBalancer\Tests;


use PharIo\Manifest\InvalidUrlException;
use Press\LoadBalancer\HostInstance;
use Press\LoadBalancer\TaskLimitations\HostInstanceInterface;
use Throwable;

class HostInstanceTest extends MockerAbstract
{

    public function testHostInstanceValidTaskLimitations(): void{
        $this->assertInstanceOf(
            HostInstanceInterface::class,
            $this->getValidHostInstance()
        );
    }

    public function testCannotBeCreatedWithInvalidUrl(): void{

        $this->expectException(InvalidUrlException::class);
        new HostInstance( "test");
    }

    public function testColdLoad(): void{
        $this->assertIsFloat($this->getValidHostInstance()->getLoad());
    }

    public function testWarmLoad(): void{
        $hostInstance = $this->getValidHostInstance();
        $hostInstance->handleRequest($this->getValidRequest());

        $this->assertIsFloat($hostInstance->getLoad());
    }

    public function testHandleRequest(): void{
        try{
            $hostInstance = $this->getValidHostInstance();
            $hostInstance->handleRequest($this->getValidRequest());
        }catch ( Throwable $e ){
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}