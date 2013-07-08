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
 * ezmageDataProvider class implementation
 */
abstract class ezmageDataProvider
{
    /**
     * Container for $handler used by data provider
     *
     * @var mixed
     */
    protected $handler;

    /**
     * Resource passed to the fetch function, usually regular URI.
     *
     * @param mixed $resource
     * @return string
     */
    abstract public function fetch( $resource );
}
