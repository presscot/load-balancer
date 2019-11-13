<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:50
 */

declare(strict_types=1);

namespace Press\LoadBalancer\TaskLimitations;

use Psr\Http\Message\RequestInterface;

/**
 * Interface HostInstanceInterface
 * @package Press\LoadBalancer\TaskLimitations
 */
interface HostInstanceInterface
{
    /**
     * @param RequestInterface $request
     */
    public function handleRequest(RequestInterface $request): void;

    /**
     * @return float
     */
    public function getLoad(): float;
}