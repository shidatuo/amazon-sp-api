<?php

namespace Amazon\SpApi;

/**
 * Class SimpleTokenStorage
 * @package Amazon\SpApi
 * @author shidatuo
 * @description token写入文件
 */
class SimpleTokenStorage implements TokenStorageInterface
{
    /**
     * @var
     */
    private $filePath;

    /**
     * SimpleTokenStorage constructor.
     * @param $filePath
     * @author shidatuo
     * @description 构造函数
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param $key
     * @return array|null
     * @author shidatuo
     * @description 获取token
     */
    public function getToken($key): ?array
    {
        $content = file_get_contents($this->filePath);

        if ($content != '') {
            $json = json_decode($content, true);
            return $json[$key] ?? null;
        }
        return null;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed|void
     * @author shidatuo
     * @description 保存token
     */
    public function storeToken($key, $value)
    {
        $json = [];
        $content = file_get_contents($this->filePath);
        if ($content != '') {
            $json = json_decode($content, true);
        }
        $json[$key] = $value;
        file_put_contents($this->filePath, json_encode($json));
    }
}
