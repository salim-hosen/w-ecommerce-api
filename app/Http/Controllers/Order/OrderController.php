<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderIndexResource;
use App\Http\Resources\Order\OrderShowResource;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use DB;

class OrderController extends Controller
{
    public function index(Request $request){

        if(auth()->user()->role == "admin"){

            return $request->q ?
                OrderIndexResource::collection(Order::where("order_uid", "like", "%$request->q%")->get())
                :
                OrderIndexResource::collection(Order::all());
        }

        return $request->q ?
                OrderIndexResource::collection(auth()->user()->orders()->where("order_uid", "like", "%$request->q%")->get())
                :
                OrderIndexResource::collection(auth()->user()->orders);

    }

    public function store(StoreOrderRequest $request){

        DB::beginTransaction();
        try{

            $total = 0;
            $items = [];

            $last_order = Order::orderBy("created_at", "desc")->first();
            $order_uid = "100000";
            if($last_order){
                $order_uid = intval($last_order->order_uid) + 1;
            }

            $order = new Order();
            $order->buyer_id = auth()->user()->id;
            $order->order_uid = $order_uid;
            $order->total = 0;
            $order->save();


            foreach ($request->all() as $item) {

                $product = Product::findOrFail($item['id']);
                $itemTotal = $product->price * $item['qty'];
                $total += $itemTotal;

                array_push($items, [
                    "order_id" => $order->id,
                    "name" => $item['name'],
                    "price" => $product->price,
                    "qty" => $item['qty'],
                    "image" => $product->image,
                    "total" => $itemTotal
                ]);
            }

            $order->total = $total;
            $order->update();
            OrderedItem::insert($items);

            DB::commit();
            return response(["message" => "Order Placed Successfully"],  Response::HTTP_CREATED);

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }

    }

    public function show(Order $order){

        return new OrderShowResource($order);

    }

    public function update(){

    }

    public function destory(){

    }
}
