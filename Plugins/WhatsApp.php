<?php

namespace Plugins;


class WhatsApp
{
    public static function send($number, $message, $image = false)
    {
        $api_key = env('WA_KEY'); // API KEY Anda
        $id_device = env('WA_ADMIN'); // ID DEVICE yang di SCAN (Sebagai pengirim)
        $url = $image ? env('WA_URL') . '/send-media' : env('WA_URL') . '/send-message'; // URL API
        $no_hp = $number; // No.HP yang dikirim (No.HP Penerima)
        $pesan = $message; // Pesan yang dikirim
        $tipe = 'image'; // Tipe Pesan Media Gambar
        $data = [
            'api_key' => $api_key,
            'sender' => $id_device,
            'number' => $no_hp,
            'message' => $pesan,
        ];

        try {
            $curl = curl_init();
            $token = $api_key;
            $data = [
                'number' => $no_hp,
                'message' => $pesan,
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    'Content-Type:application/json',
                    'API-KEY:' . $api_key
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL,  "https://wa.obsesiman.co.id/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            return $result;

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
