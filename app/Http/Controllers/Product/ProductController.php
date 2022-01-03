<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductIndexResource;
use App\Http\Resources\Product\ProductShowResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function index(Request $request){

        if ($request->q) {

            return ProductIndexResource::collection(Product::where("name", "like", "%$request->q%")
            ->get());

        }

        $products = $request->per_page ? Product::paginate(request()->per_page) : Product::all();

        return ProductIndexResource::collection($products);

    }

    public function store(StoreProductRequest $request){

        $image = uploadImage($request, "image", "images/product/", 600, 600);

        Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "qty" => $request->qty,
            "image" => $image,
            "slug" => Str::slug($request->name)
        ]);

        return response(["message" => "Created Successfully"],  Response::HTTP_CREATED);

    }

    public function show($slug){
        $product = Product::where("slug", $slug)->first();
        return new ProductShowResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product){

        $data = [];

        if($request->hasFile("image"))
            $data['image'] = uploadImage($request, "image", "images/product/", 600, 600);

        $product->update(array_merge(
            [
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "qty" => $request->qty,
                "slug" => Str::slug($request->name)
            ],
            $data
        ));

        return response(["message" => "Updated Successfully"],  Response::HTTP_OK);

    }

    public function destroy(Product $product){

        abort_if(auth()->user()->role != "admin", Response::HTTP_FORBIDDEN, "Unauthorized Access");
        deleteOldFile($product->image, "images/product");
        $product->delete();
        return response(["message" => "Deleted Successfully"],  Response::HTTP_OK);

    }
}
