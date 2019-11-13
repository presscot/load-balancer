<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 19:07
 */

require __DIR__ . '/../vendor/autoload.php';

use Press\LoadBalancer\Storage\StorageDispatcher;
use Press\LoadBalancer\Storage\Adapters\FileAdapter;
use Press\LoadBalancer\LoadBalancer;
use Press\LoadBalancer\BalancingAlgorithms\SequentialAlgorithmResolver;
use GuzzleHttp\Psr7\Request;

$hostInstances = [
    'http://localhost:8001',
    'http://localhost:8002',
    'http://localhost:8003'
];

StorageDispatcher::registerAdapter( new FileAdapter(__DIR__ . '/storage' ) );

$loadBalancer = new LoadBalancer($hostInstances, new SequentialAlgorithmResolver() );
$request= new Request("GET", "http://localhost:8000");

for( $i=0; $i < 10; ++$i ){
    $loadBalancer->handleRequest($request);
}
