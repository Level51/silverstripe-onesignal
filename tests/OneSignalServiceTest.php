<?php

namespace Level51\OneSignal;

use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;
use SilverStripe\Dev\SapphireTest;

class OneSignalServiceTest extends SapphireTest
{

    protected function setUp()
    {
        parent::setUp();

        Environment::setEnv('ONESIGNAL_APP_AUTH_KEY', 'foo');
        Environment::setEnv('ONESIGNAL_AUTH_KEY', 'bar');
        Config::forClass(OneSignalService::class)->set('app_id', 'xyz');
    }

    public function testMissingEnv1()
    {
        $this->expectException(OneSignalException::class);

        Environment::setEnv('ONESIGNAL_APP_AUTH_KEY', null);
        OneSignalService::create();
    }

    public function testMissingEnv2()
    {
        $this->expectException(OneSignalException::class);

        Environment::setEnv('ONESIGNAL_AUTH_KEY', null);
        OneSignalService::create();
    }

    public function testMissingConfig()
    {
        $this->expectException(OneSignalException::class);

        Config::forClass(OneSignalService::class)->remove('app_id');
        OneSignalService::create();
    }

    public function testCreateNotificationError()
    {
        $response = OneSignalService::singleton()->createNotification(Notification::create());

        $this->assertTrue($response->isError());
    }
}
