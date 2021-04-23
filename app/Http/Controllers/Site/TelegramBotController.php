<?php

namespace App\Http\Controllers\Site;

use App\Classes\TelegramBot;
use App\Http\Controllers\Controller;
use App\TelegramChat;

class TelegramBotController extends Controller
{
    public function index(TelegramBot $bot)
    {
        $bot->sendMessage($bot->getChatId(), 'Добро пожаловать !');
        TelegramChat::updateOrCreate(['id' => $bot->getChatId()]);
    }
}
