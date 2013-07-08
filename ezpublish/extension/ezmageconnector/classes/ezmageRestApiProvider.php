<?php
/**
 * File containing ezmageRestApiProvider class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageRestApiProvider class implementation
 */
class ezmageRestApiProvider implements ezpRestProviderInterface
{

    /**
     * Returns registered versioned routes for provider
     *
     * @return array
     */
    public function getRoutes()
    {
        return array(
            new ezpRestVersionedRoute(
                new ezcMvcRailsRoute(
                    '/product/create',
                    'ezmageRestController', 'createProduct'
                ),
                1
            ),
        );
    }

    /**
     * Returns associated with provider view controller
     *
     * @return ezpRestViewController
     */
    public function getViewController()
    {
        return new ezmageRestApiViewController();
    }
}
