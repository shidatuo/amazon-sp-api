<?php

namespace Amazon\SpApi;

use GuzzleHttp\Client;
use Amazon\SpApi\Api\Tokens;

/**
 * Class Credentials
 * @package Amazon\SpApi
 * @author shidatuo
 * @description
 */
class Credentials
{
    use HttpClientFactoryTrait;

    /**
     * @var array
     */
    private $config;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Signer
     */
    private $signer;

    /**
     * Credentials constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param Signer $signer
     * @param array $config
     * @author shidatuo
     * @description 构造函数
     */
    public function __construct(TokenStorageInterface $tokenStorage, Signer $signer, array $config = [])
    {
        $this->config = $config;
        $this->tokenStorage = $tokenStorage;
        $this->signer = $signer;
    }

    /**
     * Returns credentials
     * use $useMigrationToken = true for /authorization/v1/authorizationCode request
     * @param false $useMigrationToken
     * @return array
     * @throws \Exception
     */
    public function getCredentials($useMigrationToken = false)
    {
        $lwaAccessToken = $useMigrationToken === true ? $this->getMigrationToken() :
            ($useMigrationToken === 'grantless' ? $this->getGrantlessAuthToken() : $this->getLWAToken());
        $stsCredentials = $this->getStsTokens();

        return [
            'access_token' => $lwaAccessToken,
            'sts_credentials' => $stsCredentials
        ];
    }

    /**
     * @param array $restrictedOperations
     * @return array
     * @throws \Exception
     * @author shidatuo
     * Prepares credentials for clients which require Restricted Data Tokens
     * see: https://github.com/amzn/selling-partner-api-docs/blob/main/guides/en-US/use-case-guides/tokens-api-use-case-guide/tokens-API-use-case-guide-2021-03-01.md
     * @param  array https://github.com/amzn/selling-partner-api-docs/blob/main/references/tokens-api/tokens_2021-03-01.md#createrestricteddatatokenrequest$restrictedOperations Array with items representing CreateRestrictedDataTokenRequest
     * see: https://github.com/amzn/selling-partner-api-docs/blob/main/references/tokens-api/tokens_2021-03-01.md#createrestricteddatatokenrequest
     * @return array access_token and STS credentials
     */
    public function getRdtCredentials(array $restrictedOperations)
    {
        $rdAccessToken = $this->getRestrictedDataAccessToken($restrictedOperations);
        $stsCredentials = $this->getStsTokens();

        return [
            'access_token'    => $rdAccessToken,
            'sts_credentials' => $stsCredentials
        ];
    }

    /**
     * @param array $restrictedOperations
     * @return mixed
     * @throws \Exception
     */
    private function getRestrictedDataAccessToken($restrictedOperations = [])
    {
        $restrictedOperationsHash = md5(\json_encode($restrictedOperations));
        $tokenKey = 'restricted_data_token_' . $restrictedOperationsHash;
        $knownToken = $this->loadTokenFromStorage($tokenKey);
        if (!is_null($knownToken))
            return $knownToken;

        $cred = $this->getCredentials();
        $tokensClient = new Tokens($cred, $this->config);

        $result = $tokensClient->createRestrictedDataToken($restrictedOperations);
        $rdt = $result['restrictedDataToken'];
        $expiresOn = time() + $result['expiresIn'];

        $this->tokenStorage->storeToken($tokenKey, [
            'token' => $rdt,
            'expiresOn' => $expiresOn
        ]);

        return $rdt;
    }

    private function getLWAToken()
    {

        $knownToken = $this->loadTokenFromStorage('lwa_access_token');
        if (!is_null($knownToken)) {
            return $knownToken;
        }

        $client = $this->createHttpClient([
            'base_uri' => 'https://api.amazon.com'
        ]);

        try {
            $requestOptions = [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->config['refresh_token'],
                    'client_id' => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret']
                ]
            ];
            $response = $client->post('/auth/o2/token', $requestOptions);
        } catch (\Exception $e) {
            //log something
            throw $e;
        }
        $json = json_decode($response->getBody(), true);
        $this->tokenStorage->storeToken('lwa_access_token', [
            'token' => $json['access_token'],
            'expiresOn' => time() + ($this->config['access_token_longevity'] ?? 3600)
        ]);

        return $json['access_token'];

    }

    /**
     * @return mixed
     * @throws IncorrectResponseException
     * Request a Login with Amazon access token
     * @see https://github.com/amzn/selling-partner-api-docs/blob/main/guides/developer-guide/SellingPartnerApiDeveloperGuide.md#step-1-request-a-login-with-amazon-access-token
     */
    public function getMigrationToken()
    {
        try {
            $knownToken = $this->loadTokenFromStorage('migration_token');
            if (!is_null($knownToken))
                return $knownToken;

            // 创建http客户端
            $client = $this->createHttpClient([
                'base_uri' => 'https://api.amazon.com'
            ]);

            $requestOptions = [
                'form_params' => [
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'sellingpartnerapi::migration',
                    'client_id'     => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret']
                ]
            ];
            // 获取响应
            $response = $client->post('/auth/o2/token',$requestOptions);

            // 转化成数组
            $json = json_decode($response->getBody(),true);

        } catch (\Exception $e) {
            //log something
            throw $e;
        }

        if (!array_key_exists('access_token', $json))
            throw new IncorrectResponseException('Failed to load migration token.');

        // 保存token
        $this->tokenStorage->storeToken('migration_token',
            [
                'token'     => $json['access_token'],
                'expiresOn' => time() + $json['expires_in']
            ]
        );

        // 返回token
        return $json['access_token'];
    }

    /**
     * @return mixed
     * @throws IncorrectResponseException
     */
    public function getGrantlessAuthToken()
    {
        try {
            $knownToken = $this->loadTokenFromStorage('grantless_auth_token');
            if (!is_null($knownToken))
                return $knownToken;

            // 创建http客户端
            $client = $this->createHttpClient(
                [
                    'base_uri' => 'https://api.amazon.com'
                ]
            );

            $requestOptions = [
                'form_params' => [
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'sellingpartnerapi::notifications',
                    'client_id'     => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret']
                ]
            ];

            // 获取token
            $response = $client->post('/auth/o2/token',$requestOptions);

            // 转化成数组
            $json = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            //log something
            throw $e;
        }

        if (!array_key_exists('access_token', $json))
            throw new IncorrectResponseException('Failed to load grantless auth token.');

        // 保存token
        $this->tokenStorage->storeToken('grantless_auth_token',
            [
                'token'     => $json['access_token'],
                'expiresOn' => time() + $json['expires_in']
            ]
        );

        return $json['access_token'];
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    private function getStsTokens()
    {
        try {
            // 获取文件里面的token
            $knownToken = $this->loadTokenFromStorage('sts_credentials');
            if (!is_null($knownToken))
                return $knownToken;

            // 请求配置项
            $requestOptions = [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'form_params' => [
                    'Action'          => 'AssumeRole',
                    'DurationSeconds' => $this->config['sts_session_longevity'] ?? 3600,
                    'RoleArn'         => $this->config['role_arn'],
                    'RoleSessionName' => 'session1',
                    'Version'         => '2011-06-15',
                ]
            ];

            // 主机
            $host = 'sts.amazonaws.com';
            $uri = '/';

            // 生成签名
            $requestOptions = $this->signer->sign($requestOptions,
                [
                    'service'    => 'sts',
                    'access_key' => $this->config['access_key'],
                    'secret_key' => $this->config['secret_key'],
                    'region'     => 'us-east-1', //This should be hardcoded
                    'host'       => $host,
                    'uri'        => $uri,
                    'payload'    => \GuzzleHttp\Psr7\Query::build($requestOptions['form_params']),
                    'method'     => 'POST',
                ]
            );

            // 创建http客户端
            $client = $this->createHttpClient(
                [
                    'base_uri' => 'https://' . $host
                ]
            );

            // 发起post请求
            $response = $client->post($uri, $requestOptions);

            // 转化成数组
            $json = json_decode($response->getBody(), true);
            $credentials = $json['AssumeRoleResponse']['AssumeRoleResult']['Credentials'] ?? null;
            $tokens = [
                'access_key'    => $credentials['AccessKeyId'],
                'secret_key'    => $credentials['SecretAccessKey'],
                'session_token' => $credentials['SessionToken']
            ];
            $this->tokenStorage->storeToken('sts_credentials', [
                'token' => $tokens,
                'expiresOn' => $credentials['Expiration']
            ]);

            return $tokens;

        } catch (\Exception $e) {
            //log something
            throw $e;
        }
    }

    /**
     * Exchanges the LWA authorization code for an LWA refresh token
     * @see https://github.com/amzn/selling-partner-api-docs/blob/main/guides/developer-guide/SellingPartnerApiDeveloperGuide.md#step-5-your-application-exchanges-the-lwa-authorization-code-for-an-lwa-refresh-token
     * @param $authorizationCode
     * @return mixed
     * @throws \Exception
     */
    public function exchangesAuthorizationCodeForRefreshToken($authorizationCode)
    {
        try {
            // 创建http请求客户端
            $client = $this->createHttpClient(
                [
                    'base_uri' => 'https://api.amazon.com'
                ]
            );

            // 请求参数
            $requestOptions = [
                'form_params' => [
                    'grant_type'    => 'authorization_code',
                    'code'          => $authorizationCode,
                    'client_id'     => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret']
                ]
            ];

            // 发起请求
            $response = $client->post('/auth/o2/token', $requestOptions);

            // 转化成数组
            return json_decode($response->getBody(),true);

        } catch (\Exception $e) {

            throw $e;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    private function loadTokenFromStorage($key)
    {
        $knownToken = $this->tokenStorage->getToken($key);
        if (!empty($knownToken)) {
            $expiresOn = $knownToken['expiresOn'];
            if ($expiresOn > time()) {
                return $knownToken['token'];
            }
        }
        return null;
    }
}
