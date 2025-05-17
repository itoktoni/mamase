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
        $data = ModelsNotification::where(ModelsNotification::field_status(), NotificationStatus::Create)
            ->limit(5)
            ->get();

        foreach ($data as $item)
        {
            $check = $notification->send($item->field_name, $item->field_phone, $item->field_description, $item->field_image);
            $item->notification_status = NotificationStatus::Sent;
            $item->notification_etd = date('Y-m-d H:i:s');

            $item->notification_error = $check;

            $item->save();

            sleep(5);
        }

        $this->info("Notification Successfully Send");
    }
}
