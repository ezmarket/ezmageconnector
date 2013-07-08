<?php
/**
 * File containing ezmageProductService class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageProductService class implementation
 */
class ezmageProductService extends ezmageService
{
    const REMOTE_ID_PREFIX = 'EZMAGE_PRODUCT_ID';

    /**
     * @param string $remoteId
     * @return ezmageProduct
     */
    public function loadProductByRemoteId( $remoteId )
    {
        $remoteIdArray = explode(
            '|',
            $remoteId
        );
        $productId = isset( $remoteIdArray[1] ) ? $remoteIdArray[1] :  0;

        return $this->loadProductById( $productId );
    }

    /**
     * @param integer $productId
     * @return ezmageProduct
     */
    public function loadProductById( $productId )
    {
        $resource = '/products/' . $productId . '/images?type=rest';
        $images = array(
            'images' => json_decode( $this->handler->fetch( $resource ), true )
        );

        $resource = '/products/' . $productId . '?type=rest';
        $product  = json_decode( $this->handler->fetch( $resource ), true );

        return new ezmageProduct( $images + $product );
    }

    /**
     *
     *
     * @param string $remoteId
     * @param string $productName
     * @return eZContentObject
     */
    public function createProduct( $remoteId, $productName )
    {
        // Check if content object with requested remote ID already exist
        $contentObject = eZContentObject::fetchByRemoteID( $remoteId );
        if ( $contentObject instanceof eZContentObject )
        {
            // Define existing product attributes
            $params = array();
            $params['attributes'] = array( 'name' => $productName );

            $result = eZContentFunctions::updateAndPublishObject( $contentObject, $params );

            if ( $result )
            {
                $result = new ezcMvcResult();
                $result->variables['message'] = ezpI18n::tr(
                    'extension/ezmageconnector',
                    'Content object with remote ID "%remote_id" has been successfully updated.',
                    null,
                    array( '%remote_id' => $remoteId )
                );
                return $result;
            }
        }

        // Get Magento settings
        $ini = eZINI::instance( 'magento.ini' );

        // Define new product attributes
        $attributes = array( 'name' => $productName );

        // New product meta data
        $params = array();
        $params['creator_id'] = eZUser::currentUser()->attribute( 'contentobject_id' ); // HTTP authenticated user
        $params['class_identifier'] = $ini->variable( 'ContentSettings', 'ProductContentClass' );
        $params['parent_node_id'] = $ini->variable( 'ContentSettings', 'RootNodeID' );
        $params['remote_id'] = $remoteId;
        $params['attributes'] = $attributes;

        $contentObject = eZContentFunctions::createAndPublishObject( $params );

        return $contentObject;
    }
}
