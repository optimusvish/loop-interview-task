<?php

namespace App\Repositories;

use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;

class OrdersRepository
{
    protected $order;

    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    public function all()
    {
        return $this->order->all();
    }

    public function find($id)
    {
        return $this->order->find($id);
    }

    /**
     * Saves the resource in the database
     * @param obiect $userData
     * @return App\Models\Orders
     */
    public function create($data)
    {
        $customer = Customers::where('Email_Address', $data->customer)->first();
        $product = Products::where('productname', $data->product)->first();
        return $this->order::create([
            "customer_id" => $customer->ID,
            "product_id" => $product->ID,
            "payed" => ($data->payed) ? 1 : 0,
        ]);
    }

    public function update($id, $data)
    {
        $order = $this->order::where('payed', '0')->find($id);
        if ($order) {
            $customer = Customers::where('Email_Address', $data->customer)->first();
            $update['customer_id'] = $customer->ID;
            $product = Products::where('productname', $data->product)->first();
            $update['product_id'] = $product->ID;
            $order->update($update);
        }
        return $order;
    }

    public function delete($id)
    {
        $order = $this->order->find($id);
        if ($order) {
            $order->delete();
        }
        return $order;
    }
}
