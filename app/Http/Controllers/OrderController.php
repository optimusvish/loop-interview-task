<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\PayOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\OrderPayFactories\OrderPayFactory;
use App\Repositories\OrdersRepository;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderController extends Controller
{
    /**
     * Orders List
     */
    public function index(OrdersRepository $orderRepository)
    {
        try {
            $orders = $orderRepository->all();
            return response()->json(
                [
                    "data" => [
                        "message" => "Success",
                        "data" => $orders,
                    ],
                ],
                200
            );
        } catch (Exception $e) {
            // Handle all exceptions
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Order\StoreOrderRequest $request
     * @param  App\Repositories\OrderaRepository $orderRepository
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request, OrdersRepository $orderRepository)
    {
        try {
            $order = $orderRepository->create($request);
            return response()->json(
                [
                    "data" => [
                        "message" => "Order added Successfully!!",
                        "data" => $order,
                    ],
                ],
                201
            );
        } catch (Exception $e) {
            // Log the full exception details
            Log::info($e);

            // Return a generic error message to the user
            return response()->json([
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update not payed order with requested details
     *
     * @param  App\Http\Requests\Order\UpdateOrderRequest $request
     * @param  App\Repositories\OrderaRepository $orderRepository
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, OrdersRepository $orderRepository, $id)
    {
        try {
            $order = $orderRepository->update($id, $request);
            if ($order) {
                return response()->json(
                    [
                        "data" => [
                            "message" => "Order updated Successfully!!",
                            "data" => $order,
                        ],
                    ],
                    200
                );
            } else {
                // Log the full exception details
                Log::info("Order is Paid or Not Found!!");

                // Return a generic error message to the user
                return response()->json([
                    'message' => 'Order is Paid or Not Found!!',
                ], 500);
            }
        } catch (Exception $e) {
            // Log the full exception details
            Log::info($e);

            // Return a generic error message to the user
            return response()->json([
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }
    /**
     * Order Pay by json request
     * 
     * @param App\Http\Requests\Order\PayOrderRequest $request
     * @param $id
     * 
     */
    public function pay(PayOrderRequest $request, $id)
    {
        try {
            if ($request->validated()) {
                $orderPayFactory = new OrderPayFactory();
                $orderPay = $orderPayFactory::initializePaymnet($request->payment_method);
                return $orderPay->pay($request->validated(), $id);
            }
        } catch (Exception $e) {
            // Log the full exception details
            Log::info($e);

            // Return a generic error message to the user
            return response()->json([
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Delete order by order id and json request
     * 
     * @param $id
     * 
     */
    public function delete(OrdersRepository $orderRepository, $id)
    {
        try {
            $order = $orderRepository->delete($id);
            if ($order) {
                return response()->json(
                    [
                        "data" => [
                            "message" => "Success",
                            "data" => "deleted!",
                        ],
                    ],
                    200
                );
            } else {
                // Handle all exceptions
                return response()->json([
                    'message' => 'Invalid Order Id',
                ], 500);
            }
        } catch (Exception $e) {
            // Handle all exceptions
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
