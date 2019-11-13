<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 19:01
 */

namespace Press\LoadBalancer\Storage;

use Press\LoadBalancer\Storage\Adapters\StorageAdapterInterface;

/**
 * Class StorageDispatcher
 * @package Press\LoadBalancer\Storage
 */
final class StorageDispatcher
{
    /** @var $storageAdapter $adapter */
    static $adapter;

    /**
     * @param StorageAdapterInterface $storageAdapter
     */
    static function registerAdapter( StorageAdapterInterface $storageAdapter ): void{
        self::$adapter = $storageAdapter;
    }

    /**
     * @return StorageAdapterInterface
     */
    static function getAdapter(): StorageAdapterInterface{
        return self::$adapter;
    }

    /**
     * @return string
     */
    static function getSignature(): string{
        return md5(strtolower( explode('/',$_SERVER['SERVER_PROTOCOL'])[0]) . '://' . $_SERVER['HTTP_HOST']);
    }
}