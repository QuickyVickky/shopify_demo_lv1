<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\ProductVariantOption;
use App\Models\ProductVariant;
use App\Models\ProductImage;

class HomeController extends Controller
{

	public function index(){
		$dataProductData = Product::where('status',1)->limit(250)->get();
        $data = ['tbl' => '', 'productData' => $dataProductData];
		return view('client.test')->with($data);
	}








 



}
