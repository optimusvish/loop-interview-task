<?php

namespace App\OrderPayFactories;

use App\Models\Orders;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LoopSuperPayPayment implements OrderPayFactoryInterface
{
    public function pay(array $data, int $orderId)
    {
        try {
            $order = Orders::where('payed', '0')->find($orderId);
            if ($order) {
                // Create a new instance of the Guzzle client
                $client = new Client();

                // Make the POST request
                $response = $client->post('https://superpay.view.agentur-loop.com/pay', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $data,
                ]);

                //Get the response content
                $content = $response->getBody()->getContents();
                $contentJson = json_decode($content, true);
                if ($contentJson['message'] === "Payment Successful") {
                    $order->setPayedAttribute(true);
                    $order->updated_at = date('Y-m-d H:i:s');
                    $order->save();
                }
                return response()->json(
                    [
                        "data" => [
                            "message" => $contentJson['message'],
                            "data" => $data,
                        ],
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'error' => 'Order is already Paid OR Not Found!!'
                    ],
                    404
                );
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
}
