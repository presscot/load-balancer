<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 20:02
 */

require __DIR__ . '/../vendor/autoload.php';

use Press\LoadBalancer\Storage\StorageDispatcher;
use Press\LoadBalancer\Storage\Adapters\FileAdapter;

$headerStringValue = null;

foreach (getallheaders() as $name => $value){
    if($name === 'request_id'){
        $headerStringValue = $value;
        break;
    }
}

$signature = StorageDispatcher::getSignature();
StorageDispatcher::registerAdapter( new FileAdapter(__DIR__ . '/storage' ) );

if( $headerStringValue ){
    StorageDispatcher::getAdapter()->removeElement( $signature, $headerStringValue);
}

