<?php

namespace App\Http\Controllers\Site;

use App\Classes\TelegramBot;
use App\Http\Controllers\Controller;

class TelegramBotController extends Controller
{
    public function index(TelegramBot $bot)
    {
        $data = $bot->handler();
        $bot->sendMessage($data['message']['chat']['id'], 'Добро пожаловать !');
    }
}
