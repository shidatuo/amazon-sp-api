<?php

namespace Amazon\SpApi;

/**
 * Trait HttpClientFactoryTrait
 * @package Amazon\SpApi
 * @author shidatuo
 * @description 复用类
 */
trait HttpClientFactoryTrait
{
    /**
     * @param $config
     * @return \GuzzleHttp\Client
     * @author shidatuo
     * @description 创建http请求客户端
     */
    private function createHttpClient($config)
    {
        $httpConfig = $this->config['http'] ?? [];
        $httpConfig = array_merge($httpConfig,$config);
        return new \GuzzleHttp\Client($httpConfig);
    }
}
