<?php

namespace App\Http\Controllers\Api\Admin\Products;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Products
     *
     * Check that the Products is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Products added!.
     *
     *
     */

    public function index()
    {
        $products = Products::all();
        $products = ProductResource::collection($products);
        return response()->json([
            'success' => true,
            'data' => $products,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Add Product
     *
     * Check that the Add New Product is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Product added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'uom' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $product = new Products();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->docket = $request->docket;
            $product->uom = $request->uom;
            $product->epa_number = $request->epa_number;
            if ($request->gst_check){
                $product->gst_check = 'yes';
                $product->gst = $request->gst;
            }else{
                $product->gst_check = 'no';
                $product->gst = $request->gst;
            }
            $product->save();

            $product = Products::where('id', $product->id)->first();
            $product = new ProductResource($product);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'data' => $product,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'product_store','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Show Product
     *
     * Check that the Show Product is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Product object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $product = Products::where('id', $request->id)->first();
        if ($product)
        {
            $product = new ProductResource($product);
            return response()->json([
                'success' => true,
                'data' => $product,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Product found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     * Update Product
     *
     * Check that the Update Product is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Product updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'uom' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $product = Products::where('id', $id)->first();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->docket = $request->docket;
            $product->uom = $request->uom;
            $product->epa_number = $request->epa_number;
            if ($request->gst_check){
                $product->gst_check = 'yes';
                $product->gst = $request->gst;
            }else{
                $product->gst_check = 'no';
                $product->gst = $request->gst;
            }
            $product->save();

            $product = Products::where('id', $product->id)->first();
            $product = new ProductResource($product);

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'product_update','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|void
     */

    /**
     * Delete Product
     *
     * Check that the Delete Product is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $product = Products::findorFail($id);
            if ($product) {

                LogActivity::addToLog('Product Deleted.', Auth::user()->id);
                $product->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'product_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
