<?php

namespace Amazon\SpApi;

interface TokenStorageInterface
{
    /**
     * @param $key
     * @return array|null
     * @author shidatuo
     * @description 获取token
     */
    public function getToken($key): ?array;

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @author shidatuo
     * @description 保存token
     */
    public function storeToken($key,$value);
}
