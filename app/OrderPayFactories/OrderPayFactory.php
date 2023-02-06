<?php

namespace App\OrderPayFactories;

class OrderPayFactory
{
    public static function initializePaymnet(string $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'loop-superpay':
                return new LoopSuperPayPayment();
                break;
            default:
                throw new \Exception('Invalid payment method');
        }
    }
}
