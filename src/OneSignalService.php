<?php

namespace Level51\OneSignal;

use Nyholm\Psr7\Factory\Psr17Factory;
use OneSignal\Config;
use OneSignal\OneSignal;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injectable;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * Class OneSignalService
 *
 * @see https://github.com/norkunas/onesignal-php-api
 */
class OneSignalService
{
    use Injectable;
    use Configurable;

    /**
     * @var OneSignal
     */
    private $oneSignalClient;

    /**
     * Initializes OneSignal client with env and config vars.
     *
     * @throws OneSignalException
     */
    public function __construct()
    {
        if (!$appAuthKey = Environment::getEnv('ONESIGNAL_APP_AUTH_KEY')) {
            throw new OneSignalException(
                'Missing OneSignal app auth key. Must be an env var "ONESIGNAL_APP_AUTH_KEY".'
            );
        }

        if (!$authKey = Environment::getEnv('ONESIGNAL_AUTH_KEY')) {
            throw new OneSignalException('Missing OneSignal auth key. Must be an env var "ONESIGNAL_AUTH_KEY".');
        }

        if (!$appId = self::config()->get('app_id')) {
            throw new OneSignalException('Missing OneSignal app id. Must be a config var "app_id".');
        }

        $config = new Config($appId, $appAuthKey, $authKey);
        $httpClient = new Psr18Client();
        $requestFactory = $streamFactory = new Psr17Factory();

        $this->oneSignalClient = new OneSignal($config, $httpClient, $requestFactory, $streamFactory);
    }

    /**
     * Creates and sends a notification.
     *
     * @see https://documentation.onesignal.com/reference/create-notification#create-notification
     *
     * @param Notification $notification
     *
     * @return NotificationResponse
     */
    public function createNotification(Notification $notification)
    {
        $rawResponsePayload = $this->oneSignalClient->notifications()->add($notification->toArray());

        return new NotificationResponse($rawResponsePayload);
    }
}
