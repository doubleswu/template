<?php

namespace App\Menu;

class OrderStatus
{
    public const DEFAULT = 0; // 默认创建订单的状态

    public const PAY = 1; // 已支付

    public const DELIVERED = 2; // 已发货

    public const PAID_NOT_ENOUGH_STORE = 3; // 库存不足-已支付
}
