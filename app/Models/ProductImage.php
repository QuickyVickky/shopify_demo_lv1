<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shopify_image_id',
        'shopify_product_id',
        'vk_product_id',
        'image',
        'position',
        'created_at',
        'updated_at',
    ];

    protected $table = 'vk_product_images';

    
}
