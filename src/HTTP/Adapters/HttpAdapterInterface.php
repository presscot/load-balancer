<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 15:08
 */

declare(strict_types=1);

namespace Press\LoadBalancer\HTTP\Adapters;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpAdapterInterface
 * @package Press\LoadBalancer\HTTP\Adapters
 */
interface HttpAdapterInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request ): ResponseInterface;

    /**
     * @param RequestInterface $request
     */
    public function sendAsync(RequestInterface $request ): void;
}