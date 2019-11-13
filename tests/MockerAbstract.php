<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:57
 */

namespace Press\LoadBalancer\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use Press\LoadBalancer\HTTP\Adapters\HttpAdapterInterface;
use Press\LoadBalancer\HTTP\HttpDispatcher;
use Press\LoadBalancer\Storage\Adapters\StorageAdapterInterface;
use Press\LoadBalancer\Storage\StorageDispatcher;

abstract class MockerAbstract extends TestCase
{
    use HelperTrait;

    public function setUp(): void
    {

        $mockeryHttpAdapterInterface = Mockery::mock(HttpAdapterInterface::class);
        $mockeryHttpAdapterInterface
            ->shouldReceive('sendAsync');

        HttpDispatcher::registerAdapter($mockeryHttpAdapterInterface);

        $mockeryStorageAdapterInterface = Mockery::mock(StorageAdapterInterface::class);
        $mockeryStorageAdapterInterface->shouldReceive('add');
        $mockeryStorageAdapterInterface->shouldReceive('get');

        StorageDispatcher::registerAdapter(
            $mockeryStorageAdapterInterface
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}