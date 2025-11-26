<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Create 1-3 orders per user
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $status = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'][rand(0, 4)];
                $total = 0;

                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => $status,
                    'total_amount' => 0, // Will update later
                    'payment_method' => 'cod',
                    'shipping_address' => json_encode([
                        'name' => $user->name,
                        'address' => '123 Test St',
                        'city' => 'Mumbai',
                        'state' => 'MH',
                        'zip' => '400001'
                    ]),
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);

                // Add 1-4 items per order
                $itemCount = rand(1, 4);
                $orderProducts = $products->random($itemCount);

                foreach ($orderProducts as $product) {
                    $qty = rand(1, 2);
                    $price = $product->price;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $price,
                        'quantity' => $qty,
                    ]);

                    $total += $price * $qty;
                }

                $order->update(['total_amount' => $total]);
            }
        }
    }
}
