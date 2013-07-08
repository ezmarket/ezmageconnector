<?php
/**
 * File containing ezmageDataProvider abstract class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageRepository class implementation
 */
class ezmageRepository
{
    protected $handler;
    protected $services = array();

    /**
     * @param ezmageDataProvider $handler
     */
    public function __construct( ezmageDataProvider $handler )
    {
        $this->handler = $handler;
    }

    /**
     * @param $className
     * @return mixed
     * @throws RuntimeException
     */
    protected function service( $className )
    {
        if ( isset( $this->services[$className] ) )
            return $this->services[$className];

        if ( class_exists( $className ) )
            return $this->services[$className] = new $className( $this, $this->handler );

        throw new RuntimeException( "Could not load '$className' service!" );
    }

    /**
     * @return ezmageCategoryService
     */
    public function getCategoryService()
    {
        return $this->service( 'ezmageCategoryService' );
    }

    /**
     * @return ezmageProductService
     */
    public function getProductService()
    {
        return $this->service( 'ezmageProductService' );
    }
}
