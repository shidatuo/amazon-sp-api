<?php
/**
 * CatalogApi.
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
 * CatalogApi Class Doc Comment.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class CatalogV20220401Api
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
     * Operation getCatalogItem.
     *
     * @param $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     * @param null $includedData
     * @param null $locale
     * @return mixed
     * @throws ApiException
     */
    public function getCatalogItem($marketplace_id, $asin, $includedData = null, $locale = null)
    {
        list($response) = $this->getCatalogItemWithHttpInfo($marketplace_id, $asin, $includedData, $locale);

        return $response;
    }

    /**
     * Operation getCatalogItemWithHttpInfo.
     *
     * @param $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     * @param null $includedData
     * @param null $locale
     * @return array
     * @throws ApiException
     */
    public function getCatalogItemWithHttpInfo($marketplace_id, $asin, $includedData = null, $locale = null)
    {
        $request = $this->getCatalogItemRequest($marketplace_id, $asin, $includedData, $locale);

        return $this->sendRequest($request, 'array');
    }

    /**
     * Create request for operation 'getCatalogItem'.
     *
     * @param $marketplace_id  A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param $asin            The Amazon Standard Identification Number (ASIN) of the item. (required)
     * @param null $includedData
     * @param null $locale
     * @return Request
     */
    protected function getCatalogItemRequest($marketplace_id, $asin, $includedData = null, $locale = null)
    {
        // verify the required parameter 'marketplace_id' is set
        if (null === $marketplace_id || (is_array($marketplace_id) && 0 === count($marketplace_id))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling getCatalogItem');
        }
        // verify the required parameter 'asin' is set
        if (null === $asin || (is_array($asin) && 0 === count($asin))) {
            throw new InvalidArgumentException('Missing the required parameter $asin when calling getCatalogItem');
        }

        $resourcePath = '/catalog/2022-04-01/items/{asin}';
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

        // path params
        if (null !== $asin) {
            $resourcePath = str_replace(
                '{'.'asin'.'}',
                ObjectSerializer::toPathValue($asin),
                $resourcePath
            );
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }
}
