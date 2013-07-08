<?php
class Ez_Catalog_Model_Product_Observer
{
    public function __construct()
    {
    }
    public function catalog_product_save_after($observer)
    {
        $product = $observer->getProduct();

        $request = new HttpRequest(
            'http://ezmageconnector.dev/api/ezmage/v1/product/create',
            HttpRequest::METH_POST,
            array(
                'httpauth' => 'admin:1234', // Hardcoded for now
                'httpauthtype' => HttpRequest::AUTH_BASIC
            )
        );
        $request->setPostFields(
            array(
                'product_id' => $product->getId(),
                'product_name' => $product->getName(),
                'product_description' => $product->getDescription()
            )
        );

        try
        {
            $result = $request->send();
            $body = json_decode( $result->getBody(), true );
        }
        catch ( HttpException $e )
        {
            if ( $e instanceof HttpException )
            {
                if ( isset( $e->innerException ) )
                {
                    $message = $e->innerException->getMessage();
                }
            }
            else
            {
                $message = $e->getMessage();
            }
        }
    }
}
