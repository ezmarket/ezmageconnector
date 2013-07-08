<?php
/**
 * File containing ezmageValueObject class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */


/**
 * The base class for all value objects and structs
 *
 */
abstract class ezmageValueObject
{
    /**
     * Construct object optionally with a set of properties
     *
     * Readonly properties values must be set using $properties as they are not writable anymore
     * after object has been created.
     *
     * @param array $properties
     */
    public function __construct( array $properties = array() )
    {
        foreach ( $properties as $property => $value )
        {
            $this->$property = $value;
        }
    }

    /**
     * Function where list of properties are returned
     *
     * Used by {@see attributes()}, override to add dynamic properties
     * @uses __isset()
     *
     * @param array $dynamicProperties Additional dynamic properties exposed on the object
     *
     * @return array
     */
    protected function getProperties( $dynamicProperties = array() )
    {
        $properties = $dynamicProperties;
        foreach ( get_object_vars( $this ) as $property => $propertyValue )
        {
            if ( $this->__isset( $property ) )
                $properties[] = $property;
        }
        return $properties;
    }

    /**
     * Magic set function handling writes to non public properties
     *
     *
     * @param string $property Name of the property
     * @param string $value
     *
     * @throws ezcBasePropertyPermissionException
     * @throws ezcBasePropertyNotFoundException
     * @return void
     */
    public function __set( $property, $value )
    {
        if ( property_exists( $this, $property ) )
        {
            throw new ezcBasePropertyPermissionException( $property, ezcBasePropertyPermissionException::READ );
        }
        throw new ezcBasePropertyNotFoundException( $property );
    }

    /**
     * Magic get function handling read to non public properties
     *
     * Returns value for all readonly (protected) properties.
     *
     * @param string $property Name of the property
     *
     * @throws ezcBasePropertyNotFoundException
     * @return mixed
     */
    public function __get( $property )
    {
        if ( property_exists( $this, $property ) )
        {
            return $this->$property;
        }
        throw new ezcBasePropertyNotFoundException( $property );
    }

    /**
     * Magic isset function handling isset() to non public properties
     *
     * Returns true for all (public/)protected/private properties.
     *
     * @param string $property Name of the property
     *
     * @return boolean
     */
    public function __isset( $property )
    {
        return property_exists( $this, $property );
    }

    /**
     * Magic unset function handling unset() to non public properties
     *
     * @throws ezcBasePropertyNotFoundException exception on all writes to undefined properties so typos are not silently accepted and
     * @throws ezcBasePropertyPermissionException exception on readonly (protected) properties.
     *
     * @uses __set()
     * @param string $property Name of the property
     *
     * @return boolean
     */
    public function __unset( $property )
    {
        $this->__set( $property, null );
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param mixed[] $array
     *
     * @return ValueObject
     */
    static public function __set_state( array $array )
    {
        return new static( $array );
    }

    /**
     * Internal function for Legacy template engine compatibility to get property value
     *
     * @access private
     * @uses __get()
     *
     * @param string $property
     *
     * @return mixed
     */
    final public function attribute( $property )
    {
        return $this->__get( $property );
    }

    /**
     * Internal function for Legacy template engine compatibility to get properties
     *
     * @access private
     * @uses __isset()
     *
     * @return array
     */
    final public function attributes()
    {
        return $this->getProperties();
    }

    /**
     * Internal function for Legacy template engine compatibility to check existence of property
     *
     * @access private
     * @uses __isset()
     *
     * @param string $property
     *
     * @return boolean
     */
    final public function hasAttribute( $property )
    {
        return $this->__isset( $property );
    }
}
