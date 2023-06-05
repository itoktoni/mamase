<?php

 //script php

//   $curl = curl_init();
//             curl_setopt($curl, CURLOPT_URL, $url);
//             curl_setopt($curl, CURLOPT_HEADER, 0);
//             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//             curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
//             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//             curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
//             curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
//             curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
//             curl_setopt($curl, CURLOPT_POST, 1);

//             $data_post = [
//                 'sender' => $id_device,
//                 'api-key' => $api_key,
//                 'number' => $no_hp,
//                 'message' => $pesan,
//             ];

//             curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
//             curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//             $response = curl_exec($curl);
//             curl_close($curl);
//             return $response;


         //script php

               $curl = curl_init();

                 curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://wa.srv1.wapanels.com/send-message',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => json_encode($data),
                  CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/json'
                  ),
                  ));

                  $response = curl_exec($curl);

                  curl_close($curl);
                  echo $response;
