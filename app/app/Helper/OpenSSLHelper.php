<?php

namespace App\Helper;

class OpenSSLHelper
{
    /**
     * 加密算法 - AES-256-CBC
     */
    public const AES_256_CBC = 'AES-256-CBC';
    /**
     * 加密算法 - AES-128-CBC
     */
    public const AES_128_CBC  = 'AES-128-CBC';

    public const AES_IV = 'test-iv-uv-iuv-v';

    /**
     * @desc 加密
     * @param string $content
     * @return string
     */
    public static function aesEncrypt(string $content): string
    {
        $aesSecret  = env('AES_ENCRYPT_SECRET');
        $key = pack('C*', $aesSecret);
        $opensslEncrypt = openssl_encrypt(
            $content,
            self::AES_256_CBC,
            $key,
            OPENSSL_RAW_DATA,
            self::AES_IV
        );
        return base64_encode(self::AES_IV . $opensslEncrypt);
    }

    /**
     * @desc 解密
     * @param string $content
     * @return string
     */
    public static function aesDecrypt(string $content)
    {
        $decryptContent = base64_decode($content);
        $decryptContent = substr($decryptContent, 16);
        $aesSecret  = env('AES_ENCRYPT_SECRET');
        $key = pack('C*', $aesSecret);
        $keywords = openssl_decrypt(
            $decryptContent,
            self::AES_256_CBC,
            $key,
            OPENSSL_RAW_DATA,
            self::AES_IV
        );
        return rtrim($keywords);
    }
}
