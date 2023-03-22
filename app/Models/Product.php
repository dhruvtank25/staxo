<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'image'
    ];

    use HasFactory;

    public static function updateProduct($data, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $data['name'];
        $product->price = $data['price'];
        if(isset($data['image'])){
            $product->image = $data['image'];
        }
        return $product->save();
    }

    public static function saveProduct($data)
    {
        $product_data  = array(
                            'name'    => $data['name'],
                            'price'    => $data['price'],
                            'image'    => $data['image'],
                                );
        return Product::create($product_data, false);
    }
}
