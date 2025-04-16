<?php

namespace App\Http\Controllers;

use App\Dao\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class WebhookController extends Controller
{
    public function telegram(Request $request)
    {
        Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));

        if ($chat = $request->message) {

            $from = $chat['from'] ?? [];
            $text = $chat['text'] ?? null;
            $chat_id = $from['id'] ?? null;
            $username = $from['username'] ?? null;

            if ($text == "Register") {
                $user = User::where('username', $username)->first();

                if ($chat_id && $user) {
                    $user->update([
                        User::field_telegram() => $chat_id,
                    ]);

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => "Pendaftaran Berhasil",
                    ]);

                } else {
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => "Pendaftaran Gagal Dilakukan",
                    ]);
                }
            }
            elseif($text == "Help")
            {
                $help = 'catat username telegram'.PHP_EOL.'input ke dalam system'.PHP_EOL.'buka menu profile'.PHP_EOL.'masukan username telegram'.PHP_EOL.'untuk lebih jelas buka ducument diatas';
                $ducument = new InputFile(url('telegram.pdf'));
                Telegram::sendDocument([
                    'chat_id' => $chat_id,
                    'caption' => $help,
                    'document' => $ducument
                ]);
            }
            else {
                $reply_markup = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->row([
                        Keyboard::button('Register'),
                        Keyboard::button('Help'),
                    ])
                ;

                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "Silahkan Pilih Menu Dibawah",
                    'reply_markup' => $reply_markup,
                ]);
            }

        }
    }
}
