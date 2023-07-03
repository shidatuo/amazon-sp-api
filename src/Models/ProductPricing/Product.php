<?php
/**
 * Product.
 *
 * PHP version 5
 *
 * @author   Stefan Neuhaus / ClouSale
 */

/**
 * Selling Partner API for Pricing.
 *
 * The Selling Partner API for Pricing helps you programmatically retrieve product pricing and offer information for Amazon Marketplace products.
 *
 * OpenAPI spec version: v0
 */

namespace Amazon\SpApi\Models\ProductPricing;

use ArrayAccess;
use Amazon\SpApi\Models\ModelInterface;
use Amazon\SpApi\ObjectSerializer;

/**
 * Product Class Doc Comment.
 *

 * @description An item.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class Product implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'Product';

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'identifiers'         => '\Amazon\SpApi\Models\ProductPricing\IdentifierType',
        'attribute_sets'      => '\Amazon\SpApi\Models\ProductPricing\AttributeSetList',
        'relationships'       => '\Amazon\SpApi\Models\ProductPricing\RelationshipList',
        'competitive_pricing' => '\Amazon\SpApi\Models\ProductPricing\CompetitivePricingType',
        'sales_rankings'      => '\Amazon\SpApi\Models\ProductPricing\SalesRankList',
        'offers'              => '\Amazon\SpApi\Models\ProductPricing\OffersList'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'identifiers'         => null,
        'attribute_sets'      => null,
        'relationships'       => null,
        'competitive_pricing' => null,
        'sales_rankings'      => null,
        'offers'              => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'identifiers'         => 'Identifiers',
        'attribute_sets'      => 'AttributeSets',
        'relationships'       => 'Relationships',
        'competitive_pricing' => 'CompetitivePricing',
        'sales_rankings'      => 'SalesRankings',
        'offers'              => 'Offers'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @var string[]
     */
    protected static $setters = [
        'identifiers'         => 'setIdentifiers',
        'attribute_sets'      => 'setAttributeSets',
        'relationships'       => 'setRelationships',
        'competitive_pricing' => 'setCompetitivePricing',
        'sales_rankings'      => 'setSalesRankings',
        'offers'              => 'setOffers'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @var string[]
     */
    protected static $getters = [
        'identifiers'         => 'getIdentifiers',
        'attribute_sets'      => 'getAttributeSets',
        'relationships'       => 'getRelationships',
        'competitive_pricing' => 'getCompetitivePricing',
        'sales_rankings'      => 'getSalesRankings',
        'offers'              => 'getOffers'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    /**
     * Associative array for storing property values.
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor.
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['identifiers']         = isset($data['identifiers']) ? $data['identifiers'] : null;
        $this->container['attribute_sets']      = isset($data['attribute_sets']) ? $data['attribute_sets'] : null;
        $this->container['relationships']       = isset($data['relationships']) ? $data['relationships'] : null;
        $this->container['competitive_pricing'] = isset($data['competitive_pricing']) ? $data['competitive_pricing'] : null;
        $this->container['sales_rankings']      = isset($data['sales_rankings']) ? $data['sales_rankings'] : null;
        $this->container['offers']              = isset($data['offers']) ? $data['offers'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if (null === $this->container['identifiers']) {
            $invalidProperties[] = "'identifiers' can't be null";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed.
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return 0 === count($this->listInvalidProperties());
    }

    /**
     * Gets identifiers.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\IdentifierType
     */
    public function getIdentifiers()
    {
        return $this->container['identifiers'];
    }

    /**
     * Sets identifiers.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\IdentifierType $identifiers identifiers
     *
     * @return $this
     */
    public function setIdentifiers($identifiers)
    {
        $this->container['identifiers'] = $identifiers;

        return $this;
    }

    /**
     * Gets attribute_sets.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\AttributeSetList
     */
    public function getAttributeSets()
    {
        return $this->container['attribute_sets'];
    }

    /**
     * Sets attribute_sets.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\AttributeSetList $attribute_sets attribute_sets
     *
     * @return $this
     */
    public function setAttributeSets($attribute_sets)
    {
        $this->container['attribute_sets'] = $attribute_sets;

        return $this;
    }

    /**
     * Gets relationships.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\RelationshipList
     */
    public function getRelationships()
    {
        return $this->container['relationships'];
    }

    /**
     * Sets relationships.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\RelationshipList $relationships relationships
     *
     * @return $this
     */
    public function setRelationships($relationships)
    {
        $this->container['relationships'] = $relationships;

        return $this;
    }

    /**
     * Gets competitive_pricing.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\CompetitivePricingType
     */
    public function getCompetitivePricing()
    {
        return $this->container['competitive_pricing'];
    }

    /**
     * Sets competitive_pricing.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\CompetitivePricingType $competitive_pricing competitive_pricing
     *
     * @return $this
     */
    public function setCompetitivePricing($competitive_pricing)
    {
        $this->container['competitive_pricing'] = $competitive_pricing;

        return $this;
    }

    /**
     * Gets sales_rankings.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\SalesRankList
     */
    public function getSalesRankings()
    {
        return $this->container['sales_rankings'];
    }

    /**
     * Sets sales_rankings.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\SalesRankList $sales_rankings sales_rankings
     *
     * @return $this
     */
    public function setSalesRankings($sales_rankings)
    {
        $this->container['sales_rankings'] = $sales_rankings;

        return $this;
    }

    /**
     * Gets offers.
     *
     * @return \Amazon\SpApi\Models\ProductPricing\OffersList
     */
    public function getOffers()
    {
        return $this->container['offers'];
    }

    /**
     * Sets offers.
     *
     * @param \Amazon\SpApi\Models\ProductPricing\OffersList $offers offers
     *
     * @return $this
     */
    public function setOffers($offers)
    {
        $this->container['offers'] = $offers;

        return $this;
    }

    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param int $offset Offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param int $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int   $offset Offset
     * @param mixed $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param int $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
