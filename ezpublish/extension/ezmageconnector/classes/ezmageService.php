<?php
/**
 * File containing ezmageService class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageService class implementation
 */
class ezmageService
{
    protected $repository;
    protected $handler;

    public function __construct( ezmageRepository $repository, ezmageDataProvider $handler )
    {
        $this->repository = $repository;
        $this->handler = $handler;
    }
}
