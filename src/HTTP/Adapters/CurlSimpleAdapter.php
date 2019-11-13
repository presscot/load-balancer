<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 15:09
 */

declare(strict_types=1);

namespace Press\LoadBalancer\HTTP\Adapters;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CurlSimpleAdapter
 * @package Press\LoadBalancer\HTTP\Adapters
 */
class CurlSimpleAdapter implements HttpAdapterInterface
{
    public function send(RequestInterface $request): ResponseInterface
    {
        [$status,$header,$data] = $this->makeRequest($request, false);

        return new Response($status, [],$data);
    }

    public function sendAsync(RequestInterface $request): void
    {
        $this->makeRequest($request);
    }

    /**
     * @param RequestInterface $request
     * @param bool $async
     * @return array
     */
    protected function makeRequest(RequestInterface $request, bool $async = true): array{
        $headers = $this->getHeaders($request);

        $url = $this->parseUri($request);
        $body = $this->getBody($request);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, !!$body );
        if( $body ){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        curl_setopt($ch, CURLOPT_USERAGENT, 'load-balancer');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, !$async);
        curl_setopt($ch, CURLOPT_HEADER, !$async);
        curl_setopt($ch, CURLOPT_NOBODY, $async);

        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

        $info = curl_getinfo($ch);

        $response = curl_exec($ch);

        curl_close($ch);

        if( !$async ){
            $header = substr($response, 0, $info['header_size']);
            $data = substr($response, -$info['download_content_length']);
            $status = (int)strtok($header, "\\r\\n");

            return [$status,$header,$data];
        }

        return [];
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    protected function isPost(RequestInterface $request): bool {
        return in_array($request->getMethod(), ["post","put","delete"] );
    }

    /**
     * @param RequestInterface $request
     * @return string[]
     */
    protected function getHeaders(RequestInterface $request): array
    {
        $headers = [];

        foreach ($request->getHeaders() as $name => $values) {
            $headers[] = $name . ": " . implode(", ", $values);
        }

        return $headers;
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    protected function parseUri(RequestInterface $request): string
    {
        $uri = $request->getUri();
        $port = ( $port = $uri->getPort() ) ? ":{$port}" : "";
        $path = ( $path = $uri->getPath() ) ? "/{$path}" : "";
        $query = ( $query = $uri->getQuery() ) ? "?{$query}" : "";
        $fragment = ( $fragment = $uri->getFragment() ) ? "#{$fragment}" : "";

        return "{$uri->getScheme()}://{$uri->getHost()}{$port}{$path}{$query}{$fragment}";
    }


    /**
     * @param RequestInterface $request
     * @return string
     */
    protected function getBody(RequestInterface $request): ?string
    {
        if ( $this->isPost($request) ) {
            $body = $request->getBody();
            if ($body->getSize() > 0) {
                return (string)$body;
            }
        }

        return null;
    }
}