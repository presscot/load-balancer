<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 14:57
 */

declare(strict_types=1);

namespace Press\LoadBalancer\HTTP\Adapters;

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleAdapter
 * @package Press\LoadBalancer\HTTP\Adapters
 */
class GuzzleAdapter implements HttpAdapterInterface
{

    public function send( RequestInterface $request ): ResponseInterface
    {
        $httpClient = new Client();
        return $httpClient->send($request);
    }

    public function sendAsync( RequestInterface $request ): void{
        $httpClient = new Client();
        $promise = $httpClient->sendAsync($request);
        $promise->wait();
    }
}