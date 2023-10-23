<?php
namespace App\Http\Traits;

use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use App\Models\PushNotificationBrowser;

trait NotificationTrait{

    public static function push(int $pushBrowserId, string $body, string $url)
    {
        $subscription = Subscription::create(json_decode(PushNotificationBrowser::find($pushBrowserId)->data, true));
        $payload = '{"title":"Lead CRM", "body": "'.$body.'", "url": "'.$url.'"}';

        $auth = [
            'VAPID' => [
                'subject' => 'Lead CRM', // can be a mailto: or your website address
                "publicKey" => env('VAPID_PUBLICKEY'),
                "privateKey" => env('VAPID_PRIVATEKEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $result = $webPush->sendOneNotification($subscription, $payload, ['TTL' => 5000]);
    }

}