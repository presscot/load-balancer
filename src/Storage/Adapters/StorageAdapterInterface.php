<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 19:01
 */

namespace Press\LoadBalancer\Storage\Adapters;

/**
 * Interface StorageAdapterInterface
 * @package Press\LoadBalancer\Storage\Adapters
 */
interface StorageAdapterInterface
{
    /**
     * @param string $key
     * @param string $value
     * @param null|string $index
     */
    public function add(string $key, string $value, ?string $index = null): void;

    /**
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value): void;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     */
    public function remove(string $key): void;

    /**
     * @param string $key
     * @param $index
     */
    public function removeElement(string $key, $index ): void;

    public function clear(): void;
}