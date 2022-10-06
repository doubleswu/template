<?php

namespace App\Services\Order;

class GoodsService
{
    /**
     * @desc 校验订单里面的商品是否满足库存
     */
    public function checkGoodsByOrderId(string $orderId): array
    {
        /**
         *  一、订单本身校验
         *      1、校验订单归属
         *      2、订单号是否有效
         */

        /**
            二、检测订单里面所有的商品，依次与剩余库存对比，返回对比之后的商品结构
         */
        return [
            // 商品详细的比对数据
            'detail' => [
                'productId1' => [
                    'imgUrl' => '',
                    'lessStore' => 0,
                    'productName' => '',
                    'buyStore' => 1,
                    'pass' => false,
                ],
                'productId2' => [
                    'imgUrl' => '',
                    'lessStore' => 0,
                    'productName' => '',
                    'buyStore' => 1,
                    'pass' => true
                ],
            ],
            'pass' => true // detail里面的商品全部pass为true才返回，否则返回false
        ];
    }


    /**
     * @desc 返回商品库存信息(直接查询DB)
     * @param array $productIds
     * @return int[]
     */
    public function productStore(array $productIds): array
    {
        // 1、查询DB
        return [
            'productId1' => [
                'imgUrl' => '',
                'store' => 0,
                'pass' => true
            ],
            'productId2' => [
                'imgUrl' => '',
                'store' => 0,
                'pass' => true
            ]
        ];
    }
}
