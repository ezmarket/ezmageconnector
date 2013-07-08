ezmageconnector
===============

Magento Connector Prototype

Requirements
============

1. eZ Publish 4.7 (Legacy Stack) and higher
2. OAuth PHP extension
3. PECL HTTP

Installation
============

1. Place content of the ezpublish/extension/ezmageconnector into the extension folder inside eZ Publish root directory
2. Enable extension either in the administration interface or by editing settings/override/site.ini.append.php file and add
   [ExtensionSettings]
   ActiveExtensions[]=ezmageconnector

3. Next update autoload array by calling
   $ php bin/php/ezpgenerateautoloads.php -e –p

4. Next create a new content class [Magento Product, with identifier: magento_product] with two attributes:
   - Name [Text Line]
   - Product [Magento Product]

Configuration
=============

1. Configure settings in the extension/ezmageconnector/settings/magento.ini
   [ContentSettings]
   RootNodeID=2 # Setting that controls where new products will be created
   ProductContentClass=magento_product # Content class for Magento objects

   [RESTSettings]
   BaseURL=http://magento.local/api/rest # Path to the Magento REST API

   # OAuth settings, this params should be taken from Magento administration interface once eZ Publish is registered as an application
   [OAuthSettings]
   ConsumerKey=15ccq7lwz8qkcia5hsvur5s7un2z5dsk
   ConsumerSecret=d345kbaruzjlz8kkki93t5njbu3iw598
   AccessToken=z39oy978efm8wwnqjd9yrszckfjht7g3
   AccessTokenSecret=2hwx6awz81fvuqado567neukabxd9086

2. REST calls
   Calls from Magento should be sent as POST request to eZ Publish REST endpoint as:
   http://example.com/api/ezmage/v1/product/create

   With following post variables:
   product_id
   product_name
   product_description

