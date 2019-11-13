<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 21:54
 */

namespace Press\LoadBalancer\Tests;

use GuzzleHttp\Psr7\Request;
use Press\LoadBalancer\HostInstance;
use Press\LoadBalancer\Interfaces\HostInstanceInterface;
use Psr\Http\Message\RequestInterface;

trait HelperTrait
{
    protected function getValidRequest(): RequestInterface{
        return new Request("post",$this->getUrl());
    }

    protected function getValidHostInstance(): HostInstanceInterface{
        return new HostInstance($this->getUrl());
    }

    protected function getUrl(): string{
        return "http://localhost";
    }
}