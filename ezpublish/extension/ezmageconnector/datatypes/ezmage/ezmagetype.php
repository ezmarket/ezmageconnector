<?php
/**
 * File containing eZMageType class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezma
 */

/**
 * eZMageType class implementation
 */
class eZMageType extends eZDataType
{
    const DATA_TYPE_STRING = 'ezmage';

    /**
     * Constructor
     *
     */
    function __construct()
    {
        parent::__construct(
            self::DATA_TYPE_STRING,
            ezpI18n::tr(
                'datatype/ezmage',
                'Magento Product'
            )
        );
    }

    /**
     * Returns the content data for the given content object attribute.
     *
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @return eZPage
     */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $repository = new ezmageRepository(
            new ezmageOAuthDataProvider()
        );
        $product = $repository
            ->getProductService()
            ->loadProductByRemoteId(
                $contentObjectAttribute
                    ->object()
                    ->attribute( 'remote_id' )
            );

        return $product;
    }
}

eZDataType::register( eZMageType::DATA_TYPE_STRING, "ezmagetype" );
