<?php
/**
 * FbaInventoryApi.
 *
 * @author   Stefan Neuhaus / ClouSale
 */

/**
 * Selling Partner API for FBA Inventory.
 *
 * The Selling Partner API for FBA Inventory lets you programmatically retrieve information about inventory in Amazon's fulfillment network.
 *
 * OpenAPI spec version: v1
 */

namespace Amazon\SpApi\Api;

use Amazon\SpApi\Configuration;
use Amazon\SpApi\HeaderSelector;
use Amazon\SpApi\Helpers\SellingPartnerApiRequest;
use Amazon\SpApi\Models\FbaInventory\GetInventorySummariesResponse;
use Amazon\SpApi\ObjectSerializer;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * FbaInventoryApi Class Doc Comment.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class FbaInventoryApi
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
     * @param $granularity_type
     * @param $granularity_id
     * @param $marketplace_ids
     * @param string $details
     * @param null $start_date_time
     * @param null $seller_skus
     * @param null $next_token
     * @return array|mixed
     * @throws \Amazon\SpApi\ApiException
     */
    public function getInventorySummaries($granularity_type, $granularity_id, $marketplace_ids, $details = 'false', $start_date_time = null, $seller_skus = null, $next_token = null)
    {
        list($response) = $this->getInventorySummariesWithHttpInfo($granularity_type, $granularity_id, $marketplace_ids, $details, $start_date_time, $seller_skus, $next_token);

        return $response;
    }

    /**
     * @param $granularity_type
     * @param $granularity_id
     * @param $marketplace_ids
     * @param string $details
     * @param null $start_date_time
     * @param null $seller_skus
     * @param null $next_token
     * @return array|array[]
     * @throws \Amazon\SpApi\ApiException
     */
    public function getInventorySummariesWithHttpInfo($granularity_type, $granularity_id, $marketplace_ids, $details = 'false', $start_date_time = null, $seller_skus = null, $next_token = null)
    {
        $request = $this->getInventorySummariesRequest($granularity_type, $granularity_id, $marketplace_ids, $details, $start_date_time, $seller_skus, $next_token);

        return $this->sendRequest($request, 'array');
    }

    /**
     * @param $granularity_type
     * @param $granularity_id
     * @param $marketplace_ids
     * @param string $details
     * @param null $start_date_time
     * @param null $seller_skus
     * @param null $next_token
     * @return mixed
     * @throws \Amazon\SpApi\ApiException
     */
    public function getInventorySummariesAsync($granularity_type, $granularity_id, $marketplace_ids, $details = 'false', $start_date_time = null, $seller_skus = null, $next_token = null)
    {
        return $this->getInventorySummariesAsyncWithHttpInfo($granularity_type, $granularity_id, $marketplace_ids, $details, $start_date_time, $seller_skus, $next_token)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * @param $granularity_type
     * @param $granularity_id
     * @param $marketplace_ids
     * @param string $details
     * @param null $start_date_time
     * @param null $seller_skus
     * @param null $next_token
     * @return mixed
     * @throws \Amazon\SpApi\ApiException
     */
    public function getInventorySummariesAsyncWithHttpInfo($granularity_type, $granularity_id, $marketplace_ids, $details = 'false', $start_date_time = null, $seller_skus = null, $next_token = null)
    {
        $request = $this->getInventorySummariesRequest($granularity_type, $granularity_id, $marketplace_ids, $details, $start_date_time, $seller_skus, $next_token);

        return $this->sendRequestAsync($request, 'array');
    }

    /**
     * @param $granularity_type
     * @param $granularity_id
     * @param $marketplace_ids
     * @param string $details
     * @param null $start_date_time
     * @param null $seller_skus
     * @param null $next_token
     * @return Request
     */
    protected function getInventorySummariesRequest($granularity_type, $granularity_id, $marketplace_ids, $details = 'false', $start_date_time = null, $seller_skus = null, $next_token = null)
    {
        // verify the required parameter 'granularity_type' is set
        if (null === $granularity_type || (is_array($granularity_type) && 0 === count($granularity_type))) {
            throw new \InvalidArgumentException('Missing the required parameter $granularity_type when calling getInventorySummaries');
        }
        // verify the required parameter 'granularity_id' is set
        if (null === $granularity_id || (is_array($granularity_id) && 0 === count($granularity_id))) {
            throw new \InvalidArgumentException('Missing the required parameter $granularity_id when calling getInventorySummaries');
        }
        // verify the required parameter 'marketplace_ids' is set
        if (null === $marketplace_ids || (is_array($marketplace_ids) && 0 === count($marketplace_ids))) {
            throw new \InvalidArgumentException('Missing the required parameter $marketplace_ids when calling getInventorySummaries');
        }

        $resourcePath = '/fba/inventory/v1/summaries';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if (null !== $details) {
            $queryParams['details'] = ObjectSerializer::toQueryValue($details);
        }
        // query params
        if (null !== $granularity_type) {
            $queryParams['granularityType'] = ObjectSerializer::toQueryValue($granularity_type);
        }
        // query params
        if (null !== $granularity_id) {
            $queryParams['granularityId'] = ObjectSerializer::toQueryValue($granularity_id);
        }
        // query params
        if (null !== $start_date_time) {
            $queryParams['startDateTime'] = ObjectSerializer::toQueryValue($start_date_time);
        }
        // query params
        if (is_array($seller_skus)) {
            $seller_skus = ObjectSerializer::serializeCollection($seller_skus, 'csv', true);
        }
        if (null !== $seller_skus) {
            $queryParams['sellerSkus'] = ObjectSerializer::toQueryValue($seller_skus);
        }
        // query params
        if (null !== $next_token) {
            $queryParams['nextToken'] = ObjectSerializer::toQueryValue($next_token);
        }
        // query params
        if (is_array($marketplace_ids)) {
            $marketplace_ids = ObjectSerializer::serializeCollection($marketplace_ids, 'csv', true);
        }
        if (null !== $marketplace_ids) {
            $queryParams['marketplaceIds'] = ObjectSerializer::toQueryValue($marketplace_ids);
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }
}
