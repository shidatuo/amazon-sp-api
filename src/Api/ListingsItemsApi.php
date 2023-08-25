<?php
/**
 * ListingsItemsApi.
 *
 * @author   Stefan Neuhaus / ClouSale
 */

/**
 * Selling Partner API for Catalog Items.
 *
 * The Selling Partner API for Catalog Items helps you programmatically retrieve item details for items in the catalog.
 *
 * OpenAPI spec version: v0
 */

namespace Amazon\SpApi\Api;

use Amazon\SpApi\Configuration;
use Amazon\SpApi\HeaderSelector;
use Amazon\SpApi\Helpers\SellingPartnerApiRequest;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Amazon\SpApi\ApiException;
use Amazon\SpApi\ObjectSerializer;

/**
 * ListingsItemsApi Class Doc Comment.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class ListingsItemsApi
{
    use SellingPartnerApiRequest;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    public function __construct(Configuration $config)
    {
        $this->client = new Client();
        $this->config = $config;
        $this->headerSelector = new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation ListingsItemsApi.
     *
     * @param $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     * @param null $includedData
     * @param null $locale
     * @return mixed
     * @throws ApiException
     */
    public function getListingsItems($marketplace_id, $asin, $includedData = null, $locale = null)
    {
        list($response) = $this->getListingsItemsWithHttpInfo($marketplace_id, $asin, $includedData, $locale);

        return $response;
    }

    /**
     * Operation getListingsItemsWithHttpInfo.
     *
     * @param $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     * @param null $includedData
     * @param null $locale
     * @return array
     * @throws ApiException
     */
    public function getListingsItemsWithHttpInfo($marketplace_id, $asin, $includedData = null, $locale = null)
    {
        $request = $this->getListingsItemsRequest($marketplace_id, $asin, $includedData, $locale);

        return $this->sendRequest($request, 'array');
    }

    /**
     * @param $marketplace_id
     * @param $sellerId
     * @param $sku
     * @param null $locale
     * @param null $includedData
     * @return Request
     * @description Create request for operation 'getListingsItems'.
     */
    protected function getListingsItemsRequest($marketplace_id, $sellerId ,$sku, $locale = null,$includedData = null)
    {
        // verify the required parameter 'marketplace_id' is set
        if (null === $marketplace_id || (is_array($marketplace_id) && 0 === count($marketplace_id))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling getListingsItems');
        }
        // verify the required parameter 'sellerId' is set
        if (null === $sellerId || (is_array($sellerId) && 0 === count($sellerId))) {
            throw new InvalidArgumentException('Missing the required parameter $asin when calling getListingsItems');
        }
        // verify the required parameter 'sellerId' is set
        if (null === $sku || (is_array($sku) && 0 === count($sku))) {
            throw new InvalidArgumentException('Missing the required parameter $asin when calling getListingsItems');
        }

        $resourcePath = '/listings/2021-08-01/items/{sellerId}/{sku}';
        $formParams   = [];
        $queryParams  = [];
        $headerParams = [];
        $httpBody     = '';
        $multipart    = false;

        // query params
        if (null !== $marketplace_id) {
            $queryParams['marketplaceIds'] = ObjectSerializer::toQueryValue($marketplace_id);
        }

        // query params
        if (null !== $includedData) {
            $queryParams['includedData'] = ObjectSerializer::toQueryValue($includedData);
        }

        // query params
        if (null !== $locale) {
            $queryParams['locale'] = ObjectSerializer::toQueryValue($locale);
        }

        // query params
        if (null !== $sellerId) {
            $queryParams['sellerId'] = ObjectSerializer::toQueryValue($sellerId);
        }

        // query params
        if (null !== $sku) {
            $queryParams['sku'] = ObjectSerializer::toQueryValue($sku);
        }

        // path params
        if (null !== $sellerId) {
            $resourcePath = str_replace(
                '{'.'sellerId'.'}',
                ObjectSerializer::toPathValue($sellerId),
                $resourcePath
            );
        }

        // path params
        if (null !== $sku) {
            $resourcePath = str_replace(
                '{'.'sku'.'}',
                ObjectSerializer::toPathValue($sku),
                $resourcePath
            );
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }
}
