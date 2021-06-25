<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shopify_variant_id',
        'shopify_product_id',
        'vk_product_id',
        'title',
        'price',
        'sku',
        'grams',
        'inventory_quantity',
        'admin_graphql_api_id',
        'option1',
        'option2',
        'option3',
        'barcode',
        'created_at',
        'updated_at',
        'image_id',
    ];

    protected $table = 'vk_product_variants';

    
}
