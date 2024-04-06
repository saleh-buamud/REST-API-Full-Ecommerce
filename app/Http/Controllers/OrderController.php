<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(20);
        if ($orders) {
            foreach ($orders as $order) {
                foreach ($order->items as $order_item) {
                    $product = Product::where('id', $order_item->product_id)->pluck('name');
                    $order_item->product->name = $product['0'];
                }
            }

            return response()->json($orders, 200);
        } else {
            return response()->json(['error' => 'No orders found'], 404);
        }
    }

    public function show_Order(string $id)
    {
        $order = Order::find($id);
        if ($order) {
            return response()->json([
                'order' => $order,
                'msg' => 'found order',
            ]);
        }
        return response()->json(['error' => 'No such order'], 404);
    }

    public function store_Order(Request $request)
    {
        $location = Location::where('user_id', Auth::id())->first();
        $request->validate([
            'order_items' => 'required',
            'total_price' => 'required',
            'quantity' => 'required',
            'date_of_delivery' => 'required',
        ]);
        $order = new Order();
        $order->user_id = Auth::id();
        $order->location_id = $location->id;
        $order->total_price = $request->total_price;
        $order->date_of_delivery = $request->date_of_delivery;
        $order->save();
        foreach ($request->order_items as $order_item) {
            $items = new OrderItem();
            $items->order_id = $order->id;
            $items->product_id = $order_item['product_id'];
            $items->quantity = $order_item['quantity'];
            $items->save();
            //  $product = Product::where('id', $order_item['product_id'])->first();
            //  $product->quantity - =   $order_item['quantity'];
            //  $product->save();

            $product = Product::where('id', $order_item['product_id'])->first();
            $product->quantity -= $order_item['quantity']; // تقليل كمية المنتج بكمية الطلب
            $product->save();
        }
        return response()->json([
            'order' => $order,
            'msg' => 'order created',
        ]);
    }

    public function get_order_items(string $id)
    {
        $orderItems = OrderItem::where('order_id', '=', $id)->get();
        if ($orderItems) {
            foreach ($order_items as $order_item) {
                $products = Product::where('id', $order_item->product_id)->pluck('name');
                $order_item->product->name = $products['0'];
            }
            return response()->json($orderItems);
        } else {
            return 'Error';
        }
    }

    public function get_user_orders($id)
    {
        $orders = Order::where('user_id', $id)
            ::with('items', function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->get();
        if ($orders) {
            foreach ($orders->items as $order) {
                $product = Product::where('id', $order->product_id)->pluck('name');
                $order->product_name = $product['0'];
            }
            return response()->json(['data' => $orders]);
        } else {
            return response()->json(['error' => 'No orders found'], 404);
        }
    }

    public function change_order_status(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        if ($order) {
            $order->update(['status' => $request->status]);
            return response()->json(['msg' => 'Order status updated']);
        }
        return response()->json(['error' => 'Order not found'], 404);
    }
}
