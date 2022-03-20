<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProductStoreRequest;

class ApiProductController extends Controller
{
    public function products()
    {
        return Product::latest()->get();
    }

    public function store(ProductStoreRequest $r)
    {
        $data = $r->validated();

        $image = time();

        Image::make($data['image'])
            ->encode('png', 75)
            ->save(public_path("img/products/$image.png"));

        $data['image'] = "img/products/$image.png";

        $data['store_id'] = auth()->user()->id;

        $product = Product::create($data);

        return response([
            'product' => $product,
        ], 200);
    }

    public function myProducts()
    {
        return auth()->user()->products;
    }

    public function master()
    {
        // $user = User::WhereNotNull('approved_as_store_owner_at')->get();
        $user = User::get();
        $store = collect([]);
        $category = null;

        foreach ($user as $key=>$u) {
            $category = Product::whereStoreId($u->id)->get()->groupBy(function ($e) {
                return $e->category;
            });

            $u->categories = count($category) == 0 ? new stdClass():$category;
        }

        return $user;
    }
}
