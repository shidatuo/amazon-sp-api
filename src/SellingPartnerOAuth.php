<?php

namespace Amazon\SpApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class SellingPartnerOAuth
{
    /**
     * @param $refreshToken
     * @param $clientId
     * @param $clientSecret
     * @return array|null
     */
    public static function getAccessTokenFromRefreshToken($refreshToken, $clientId, $clientSecret): ?array
    {
        // 实例化客户端
        $client = new Client();
        $params = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
        ];
        $options = array_merge([
            RequestOptions::HEADERS => ['Accept' => 'application/json'],
            RequestOptions::HTTP_ERRORS => false,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ],
        ], $params ? [RequestOptions::FORM_PARAMS => $params] : []);

        // 发起请求
        $response = $client->request('POST', 'https://api.amazon.com/auth/o2/token', $options);

        // 获取返回值
        $body = $response->getBody()->getContents();

        // 转化成数组
        return json_decode($body, true);
    }

    /**
     * @param string $lwaAuthorizationCode
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     * @return array|null
     */
    public static function getRefreshTokenFromLwaAuthorizationCode(
        string $lwaAuthorizationCode,
        string $clientId,
        string $clientSecret,
        string $redirectUri
    ): ?array {
        // 实例化客户端
        $client = new Client();
        $params = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'code'          => $lwaAuthorizationCode,
            'redirect_uri'  => $redirectUri,
        ];
        $options = array_merge([
            RequestOptions::HEADERS => ['Accept' => 'application/json'],
            RequestOptions::HTTP_ERRORS => false,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ],
        ], $params ? [RequestOptions::FORM_PARAMS => $params] : []);

        // 请求接口
        $response = $client->request('POST', 'https://api.amazon.com/auth/o2/token', $options);

        // 获取返回值
        $body = $response->getBody()->getContents();

        // 转化成数组
        return json_decode($body, true);
    }
}
