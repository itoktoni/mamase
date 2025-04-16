<?php

namespace App\Console\Commands;

use App\Contracts\NotificationInterface;
use App\Dao\Enums\JobStatusType;
use App\Dao\Enums\NotificationStatus;
use App\Dao\Models\Notification as ModelsNotification;
use App\Facades\Model\NotificationModel;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(NotificationInterface $notification)
    {
        $data = ModelsNotification::whereNull(ModelsNotification::field_status())
            ->limit(5)
            ->get();

        foreach ($data as $item)
        {
            $check = $notification->send($item->notification_nama, $item->notification_alamat, $item->notification_pesan, $item->notification_gambar);
            $item->notification_status = NotificationStatus::Sent;
            $item->notification_tanggal = date('Y-m-d');

            $item->notification_response = $check;

            $item->save();

            sleep(5);
        }

        $this->info("Notification Successfully Send");
    }
}
