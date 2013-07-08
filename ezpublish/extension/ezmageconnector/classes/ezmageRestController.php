<?php
/**
 * File containing ezmageRestController class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageRestController class implementation
 */
class ezmageRestController extends ezcMvcController
{
    const REMOTE_ID_PREFIX = 'EZMAGE_PRODUCT_ID';

    /**
     * Constructor
     *
     * @param string $action
     * @param ezcMvcRequest $request
     */
    public function __construct( $action, ezcMvcRequest $request )
    {
        parent::__construct( $action, $request );

        // Initialize module loading
        $moduleRepositories = eZModule::activeModuleRepositories();
        eZModule::setGlobalPathList( $moduleRepositories );
    }

    /**
     * @return ezcMvcResult
     */
    public function doCreateProduct()
    {
        // Get POST data from given HTTP request
        $productId = $this->request->post['product_id'];
        $productName = $this->request->post['product_name'];
        $remoteId = self::REMOTE_ID_PREFIX . '|' . $productId;

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

        $result = new ezcMvcResult();
        $result->variables['message'] = ezpI18n::tr(
            'extension/ezmageconnector',
            'Content object with remote ID "%remote_id" has been successfully created.',
            null,
            array( '%remote_id' => $remoteId )
        );
        return $result;
    }
}
