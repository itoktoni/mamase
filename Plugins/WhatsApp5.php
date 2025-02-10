<?php

namespace Plugins;

class WhatsApp5
{
    public static function send($number, $message, $image = false)
    {
        $api_key = env('WA_KEY'); // API KEY Anda
        $id_device = env('WA_ADMIN'); // ID DEVICE yang di SCAN (Sebagai pengirim)
        $url = $image ? env('WA_URL') . '/send-media' : env('WA_URL') . '/send-message'; // URL API
        $no_hp = $number; // No.HP yang dikirim (No.HP Penerima)
        $pesan = $message; // Pesan yang dikirim
        $tipe = 'image'; // Tipe Pesan Media Gambar

        if (!empty($no_hp)) {

            $hp = ltrim($no_hp, '0');

            $data = [
                'chatId' => '62'.$hp . '@c.us',
                'text' => $pesan,
            ];

            try {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://62.72.30.42:8085/message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type:application/json',
                        'API-KEY:' . $api_key,
                    ],
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                return $response;

            } catch (\Throwable $th) {
                $error = [
                    'kode' => 500,
                    'status' => false,
                    'message' => [
                        $th->getMessage(),
                    ],
                ];

                return $error;
            }

        }

    }
}
