<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shopify_option_id',
        'shopify_product_id',
        'vk_product_id',
        'name',
        'created_at',
        'updated_at',
        'position',
        'values_text',
    ];

    protected $table = 'vk_product_variant_options';

    
}
