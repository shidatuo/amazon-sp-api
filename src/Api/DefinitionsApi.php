<?php
/**
 * DefinitionsApi.
 *
 * @author   Stefan Neuhaus / ClouSale
 */

/**
 * Selling Partner API for DefinitionsApi.
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
 * DefinitionsApi Class Doc Comment.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class DefinitionsApi
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
     * Operation searchDefinitionsProductTypes.
     *
     * @param $marketplace_id
     * @param $keywords
     * @return array|mixed
     * @throws ApiException
     */
    public function searchDefinitionsProductTypes($marketplace_id, $keywords)
    {
        list($response) = $this->searchDefinitionsProductTypesWithHttpInfo($marketplace_id, $keywords);

        return $response;
    }

    /**
     * Operation searchDefinitionsProductTypesWithHttpInfo.
     *
     * @param $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param null $keywords
     * @return array|array[]
     * @throws ApiException
     */
    public function searchDefinitionsProductTypesWithHttpInfo($marketplace_id, $keywords = null)
    {
        $request = $this->searchDefinitionsProductTypesRequest($marketplace_id, $keywords);

        return $this->sendRequest($request, 'array');
    }

    /**
     * Create request for operation 'searchDefinitionsProductTypesRequest'.
     *
     * @param $marketplace_id
     * @param null $keywords
     * @return Request
     */
    protected function searchDefinitionsProductTypesRequest($marketplace_id, $keywords = null)
    {
        // verify the required parameter 'marketplace_id' is set
        if (null === $marketplace_id || (is_array($marketplace_id) && 0 === count($marketplace_id))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling searchDefinitionsProductTypesRequest');
        }

        $resourcePath = '/definitions/2020-09-01/productTypes';
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
        if (null !== $keywords) {
            $queryParams['keywords'] = ObjectSerializer::toQueryValue($keywords);
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }

    /**
     * @param $marketplace_id
     * @param $product_type
     * @param null $seller_id
     * @param null $product_type_version
     * @param null $requirements
     * @param null $requirements_enforced
     * @param null $locale
     * @return array|mixed
     * @throws ApiException
     */
    public function getDefinitionsProductType($marketplace_id,$product_type,$seller_id = null,$product_type_version = null,$requirements = null,$requirements_enforced = null,$locale = null)
    {
        list($response) = $this->getDefinitionsProductTypeWithHttpInfo($marketplace_id, $product_type, $seller_id,$product_type_version,$requirements,$requirements_enforced,$locale);

        return $response;
    }

    /**
     * @param $marketplace_id
     * @param $product_type
     * @param null $seller_id
     * @param null $product_type_version
     * @param null $requirements
     * @param null $requirements_enforced
     * @param null $locale
     * @return array|array[]
     * @throws ApiException
     */
    public function getDefinitionsProductTypeWithHttpInfo($marketplace_id,$product_type,$seller_id = null,$product_type_version = null,$requirements = null,$requirements_enforced = null,$locale = null)
    {
        $request = $this->getDefinitionsProductTypeRequest($marketplace_id, $product_type, $seller_id,$product_type_version,$requirements,$requirements_enforced,$locale);

        return $this->sendRequest($request, 'array');
    }

    /**
     * @param $marketplace_id
     * @param $product_type
     * @param null $seller_id
     * @param null $product_type_version
     * @param null $requirements
     * @param null $requirements_enforced
     * @param null $locale
     * @return Request
     */
    protected function getDefinitionsProductTypeRequest($marketplace_id,$product_type,$seller_id = null,$product_type_version = null,$requirements = null,$requirements_enforced = null,$locale = null)
    {
        // verify the required parameter 'marketplace_id' is set
        if (null === $marketplace_id || (is_array($marketplace_id) && 0 === count($marketplace_id))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling getDefinitionsProductTypeRequest');
        }

        // verify the required parameter 'marketplace_id' is set
        if (null === $product_type || (is_array($product_type) && 0 === count($product_type))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling getDefinitionsProductTypeRequest');
        }

        $resourcePath = '/definitions/2020-09-01/productTypes/{productType}';
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
        if (null !== $product_type) {
            $queryParams['productType'] = ObjectSerializer::toQueryValue($product_type);
        }

        // query params
        if (null !== $seller_id) {
            $queryParams['sellerId'] = ObjectSerializer::toQueryValue($seller_id);
        }

        // query params
        if (null !== $product_type_version) {
            $queryParams['productTypeVersion'] = ObjectSerializer::toQueryValue($product_type_version);
        }

        // query params
        if (null !== $requirements) {
            $queryParams['requirements'] = ObjectSerializer::toQueryValue($requirements);
        }

        // query params
        if (null !== $requirements_enforced) {
            $queryParams['requirementsEnforced'] = ObjectSerializer::toQueryValue($requirements_enforced);
        }

        // query params
        if (null !== $locale) {
            $queryParams['locale'] = ObjectSerializer::toQueryValue($locale);
        }

        // path params
        if (null !== $product_type) {
            $resourcePath = str_replace(
                '{'.'productType'.'}',
                ObjectSerializer::toPathValue($product_type),
                $resourcePath
            );
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }
}
