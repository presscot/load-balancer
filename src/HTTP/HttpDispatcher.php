<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 19:12
 */

declare(strict_types=1);

namespace Press\LoadBalancer\HTTP;

use Press\LoadBalancer\HTTP\Adapters\CurlSimpleAdapter;
use Press\LoadBalancer\HTTP\Adapters\HttpAdapterInterface;

/**
 * Class HttpDispatcher
 * @package Press\LoadBalancer\HTTP
 */
final class HttpDispatcher
{
    /** @var HttpAdapterInterface $adapter */
    static $adapter;

    /**
     * @param HttpAdapterInterface $httpAdapter
     */
    static function registerAdapter( HttpAdapterInterface $httpAdapter ): void{
        self::$adapter = $httpAdapter;
    }

    /**
     * @return HttpAdapterInterface
     */
    static function getAdapter(): HttpAdapterInterface{
        return self::$adapter ?? new CurlSimpleAdapter();
    }
}