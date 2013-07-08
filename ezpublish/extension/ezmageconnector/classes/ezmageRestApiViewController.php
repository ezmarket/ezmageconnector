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
 * ezmageRestApiViewController class implementation
 */
class ezmageRestApiViewController implements ezpRestViewControllerInterface
{

    /**
     * Creates a view required by controller's result
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult $result
     * @return ezcMvcView
     */
    public function loadView(ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result)
    {
        return new ezpRestJsonView( $request, $result );
    }
}
