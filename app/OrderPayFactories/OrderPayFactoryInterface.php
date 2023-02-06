<?php

namespace App\OrderPayFactories;

interface OrderPayFactoryInterface
{
    public function pay(array $data, int $orderID);
}
