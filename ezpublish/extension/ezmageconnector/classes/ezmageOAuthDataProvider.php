<?php
/**
 * File containing ezmageOAuthDataProvider class
 *
 * @copyright //autogen//
 * @license //autogen//
 * @version //autogen//
 * @package ezmage
 */

/**
 * ezmageOAuthDataProvider class implementation
*/
class ezmageOAuthDataProvider extends ezmageDataProvider
{
    /**
     * Resource base URL. Used for prefixing resources passed to {@see fetch()} method
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Setup OAuth handler for usage by services
     */
    public function __construct()
    {
        $ini = eZINI::instance( 'magento.ini' );

        $oauthClient = new OAuth(
            $ini->variable('OAuthSettings', 'ConsumerKey'),
            $ini->variable('OAuthSettings', 'ConsumerSecret'),
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_AUTHORIZATION
        );
        $oauthClient->enableDebug();
        $oauthClient->setToken(
            $ini->variable( 'OAuthSettings', 'AccessToken' ),
            $ini->variable( 'OAuthSettings', 'AccessTokenSecret' )
        );

        $this->handler = $oauthClient;
        $this->baseUrl = $ini->variable( 'RESTSettings', 'BaseURL' );
    }

    /**
     * Resource passed to the fetch function, usually regular URI.
     *
     * @param mixed $resource
     * @return string
     */
    public function fetch( $resource )
    {
        $this->handler->fetch(
            $this->baseUrl . $resource,
            array(),
            'GET',
            array( 'Content-Type' => 'application/json' )
        );

        return $this->handler->getLastResponse();
    }
}
