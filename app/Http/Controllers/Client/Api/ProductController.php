<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductVariantOption;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
date_default_timezone_set('Asia/Kolkata');


class ProductController extends Controller
{


    public function __construct()
    {
        ini_set('max_execution_time', 2000);
    }



    public function getProductList(Request $request) {
        try {

        $limit = 250; $page_info = '&page_info=eyJsYXN0X2lkIjo2NzIwNDEwNjQ4NzI5LCJsYXN0X3ZhbHVlIjoiQXJ0aXN0aWMgTXVsdGkgQ29sb3JlZCBTaWxrIEZhYnJpYyBTYXJlZSBGb3IgV29tZW4gd2l0aCBCbG91c2UgUGllY2UiLCJkaXJlY3Rpb24iOiJuZXh0In0';


        if(isset($request->limit) && $request->limit > 0 && $request->limit <= 250){
            $limit = $request->limit;
        }

        if(isset($request->page_info)){
            $page_info = '&page_info='.$request->page_info;
        }




        $ch = curl_init();
        $url = env('SHOPIFY_API_URL').env('SHOPIFY_API_VERSION').'/products.json?limit='.$limit;
        curl_setopt($ch, CURLOPT_USERPWD, env('SHOPIFY_API_KEY').':'.env('SHOPIFY_API_PASSWORD'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $body = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($body, 0, $headerSize);
        $header = $this->getHeaders($header);


        $body = substr($body, $headerSize);

        curl_close($ch);

        //return ['success' => 1,'header' => $header, 'data' => json_decode($body, true)  , 'msg' => 'Found' ];

        if(!isset($body)) {
            return ['success' => 0, 'data' => NULL , 'msg' => 'Not Found.' ];
        }
        else
        {


            $body = json_decode($body, true);

            if(!empty($body['products']) && is_array($body['products'])){
                foreach ($body['products'] as $keyProduct => $valueProduct) {
                $countProduct = Product::where('shopify_product_id',$valueProduct['id'])->count();

                    if($countProduct==0){
                        $dataInsertProduct = [
                            "title" => $valueProduct['title'],
                            "tags" => $valueProduct['tags'],
                            "handle" => $valueProduct['handle'],
                            "status" => 1,
                            "shopify_product_id" => $valueProduct['id'],
                            "body_html" => $valueProduct['body_html'],
                            "vendor" => $valueProduct['vendor'],
                            "product_type" => $valueProduct['product_type'],
                            "admin_graphql_api_id" => $valueProduct['admin_graphql_api_id'],
                        ];
                    $dataInsertedProductData = Product::create($dataInsertProduct);

                    /*----variant---starts---*/
                    if(!empty($valueProduct['variants']) && is_array($valueProduct['variants'])){

                        foreach ($valueProduct['variants'] as $keyProductVariant => $valueProductVariant) {
                            $countProductVariant = ProductVariant::where('shopify_variant_id',$valueProductVariant['id'])->count();

                            if($countProductVariant==0){
                                $dataInsertProductVariant = [
                                    "shopify_variant_id" => $valueProductVariant['id'],
                                    "vk_product_id" => $dataInsertedProductData->id,
                                    "title" => $valueProductVariant['title'],
                                    "shopify_product_id" => $valueProductVariant['product_id'],
                                    "price" => $valueProductVariant['price'],
                                    "sku" => $valueProductVariant['sku'],
                                    "grams" => $valueProductVariant['grams'],
                                    "inventory_quantity" => $valueProductVariant['inventory_quantity'],
                                    "admin_graphql_api_id" => $valueProductVariant['admin_graphql_api_id'],
                                    "option1" => $valueProductVariant['option1'],
                                    "option2" => $valueProductVariant['option2'],
                                    "option3" => $valueProductVariant['option3'],
                                    "barcode" => $valueProductVariant['barcode'],
                                    "image_id" => $valueProductVariant['image_id'],
                                ];
                            $dataInsertedProductVariantData = ProductVariant::create($dataInsertProductVariant);
                            }
                        }
                    }
                    /*----variant--ends-----*/

                    /*----options---starts---*/
                    if(!empty($valueProduct['options']) && is_array($valueProduct['options'])){

                        foreach ($valueProduct['options'] as $keyProductVariantOption => $valueProductVariantOption) {
                            $countProductVariantOption = ProductVariantOption::where('shopify_option_id',$valueProductVariantOption['id'])->count();

                            if($countProductVariantOption==0){
                                $dataInsertProductVariantOption = [
                                    "shopify_option_id" => $valueProductVariantOption['id'],
                                    "vk_product_id" => $dataInsertedProductData->id,
                                    "name" => $valueProductVariantOption['name'],
                                    "shopify_product_id" => $valueProductVariantOption['product_id'],
                                    "position" => $valueProductVariantOption['position'],
                                    "values_text" => @implode(',', $valueProductVariantOption['values']),
                                ];
                            $dataInsertedProductVariantOptionData = ProductVariantOption::create($dataInsertProductVariantOption);
                            }
                        }
                    }
                    /*----options--ends-----*/

                    /*----images---starts---*/
                    if(!empty($valueProduct['images']) && is_array($valueProduct['images'])){

                        foreach ($valueProduct['images'] as $keyProductImage => $valueProductImage) {
                            $countProductImage = ProductImage::where('shopify_image_id',$valueProductImage['id'])->count();

                            if($countProductImage==0){
                                $dataInsertProductImage = [
                                    "shopify_image_id" => $valueProductImage['id'],
                                    "vk_product_id" => $dataInsertedProductData->id,
                                    "image" => $valueProductImage['src'],
                                    "shopify_product_id" => $valueProductImage['product_id'],
                                    "position" => $valueProductImage['position'],
                                ];
                            $dataInsertedProductImageData = ProductImage::create($dataInsertProductImage);
                            }
                        }
                    }
                    /*----images--ends-----*/
                    }

                }
            }



            $nextPageURL = $this->str_btwn($header['link'], '<', '>');
            $nextPageURLparam = parse_url($nextPageURL); 
            parse_str($nextPageURLparam['query'], $value);
            $page_info = $value['page_info'];


            return ['success' => 1, 'header' => $header, 'nextPageURLparam' => $nextPageURLparam,  'data' => $body, 'msg' => 'Successful.' ];
        }

        } catch(\Exception $e) {
            Log::error($e);
            return ['success' => 0, 'data' => $e->getMessage() , 'msg' => 'Error' ];
        }
    }	











public function getHeaders($respHeaders) {
    $headers = array();

    $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));

    foreach (explode("\r\n", $headerText) as $i => $line) {
        if ($i === 0) {
            $headers['http_code'] = $line;
        } else {
            list ($key, $value) = explode(': ', $line);
            $headers[$key] = $value;
        }
    }
    return $headers;
}




public function str_btwn($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}






















}
