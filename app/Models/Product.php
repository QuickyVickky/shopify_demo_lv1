<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'shopify_product_id',
        'body_html',
        'vendor',
        'product_type',
        'tags',
        'status',
        'handle',
        'admin_graphql_api_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'vk_products';

    
}
