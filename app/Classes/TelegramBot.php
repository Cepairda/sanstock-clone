<?php

namespace App\Classes;

use GuzzleHttp\Client;

class TelegramBot
{
    private const TOKEN_ACCESS = '1720582810:AAGhvUgXxixOseClvyvN7NpzD4AF2NjLHZw';
    private const API_LINK = 'https://api.telegram.org/bot';

    public function handler()
    {
        $data = file_get_contents('php://input');
        return json_decode($data, true);
    }

    protected function baseApiUrl()
    {
        return (self::API_LINK . self::TOKEN_ACCESS . '/');
    }

    protected function createClient()
    {
        return new Client(['base_uri' => $this->baseApiUrl()]);
    }

    function send($methodName, $response)
    {
        $client = $this->createClient();
        $client->post($methodName, $response);
    }

    public function sendMessage($chatId, $text)
    {
        $request = [
            'query' => [
                'chat_id' => $chatId,
                'text' => $text,
            ]
        ];

        $this->send('sendMessage', $request);
    }
}
