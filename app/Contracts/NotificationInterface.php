<?php

namespace App\Contracts;

interface NotificationInterface
{
    public function send($nama, $alamat, $pesan, $gambar = null);
}