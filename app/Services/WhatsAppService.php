<?php

namespace App\Services;

class WhatsAppService
{
    public static function waLink(string $phone, string $message = ''): ?string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) < 10 || strlen($phone) > 15) {
            return null;
        }

        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        $url = 'https://wa.me/' . $phone;
        if (!empty($message)) {
            $url .= '?text=' . rawurlencode($message);
        }

        return $url;
    }
}
