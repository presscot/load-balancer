<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 13:42
 */

declare(strict_types=1);

namespace Press\LoadBalancer;

use GuzzleHttp\Psr7\Uri;
use PharIo\Manifest\InvalidUrlException;
use Press\LoadBalancer\HTTP\HttpDispatcher;
use Press\LoadBalancer\Interfaces\HostInstanceInterface;
use Press\LoadBalancer\HTTP\Adapters\HttpAdapterInterface;
use Press\LoadBalancer\Storage\StorageDispatcher;
use Psr\Http\Message\RequestInterface;

/**
 * Class HostInstance
 * @package Press\LoadBalancer
 */
class HostInstance implements HostInstanceInterface
{

    /** @var int $counter */
    static $counter = 0;

    /** @var int $load */
    private $load = 0;

    /** @var string $instanceHost */
    public $instanceHost;

    /** @var string $hash */
    public $hash;

    /** @var HttpAdapterInterface $httpAdapter */
    private $httpAdapter;

    /**
     * HostInstance constructor.
     * @param string $instanceHost
     * @throws InvalidUrlException
     */
    public function __construct(string $instanceHost)
    {
        if (!filter_var($instanceHost, FILTER_VALIDATE_URL)){
            throw new InvalidUrlException();
        }

        $this->instanceHost = $instanceHost;

        $this->hash = md5($instanceHost);

        $this->httpAdapter = HttpDispatcher::getAdapter();

        $this->restoreLoad();
    }

    /**
     * @param RequestInterface $request
     */
    public function handleRequest(RequestInterface $request): void
    {
        //$this->updateStats();
        $request = $this->prepareRequest($request);

        $this->httpAdapter->sendAsync($request);
    }

    /**
     * @return float
     */
    public function getLoad(): float
    {
        $storage = StorageDispatcher::getAdapter();

        return  count( $storage->get($this->hash) ?? [] ) / HostInstanceInterface::LOAD_DIV;//$this->load / HostInstanceInterface::LOAD_DIV; //self::$counter ? $this->load / self::$counter : 0;
    }

    /**
     * @return string
     */
    protected function getInstanceHost(): string
    {
        return $this->instanceHost;
    }

    protected function updateStats(): void
    {
        ++self::$counter;
        ++$this->load;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function prepareRequest(RequestInterface $request): RequestInterface
    {
        $uri = new Uri($this->getInstanceHost());

        $id = md5(time().rand(0,9999).$this->getInstanceHost());

        $request = $request->withHeader("request_id", $id);

        $storage = StorageDispatcher::getAdapter();
        $storage->add($this->hash, time().'', $id);

        return $request->withUri($request->getUri()->withHost($uri->getHost())->withPort($uri->getPort()));
    }

    /**
     *
     */
    private function restoreLoad(): void
    {
    }
}