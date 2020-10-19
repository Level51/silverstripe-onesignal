<?php

namespace Level51\OneSignal;

use SilverStripe\Dev\SapphireTest;

class OneSignalServiceTest extends SapphireTest {

    public function testCreateNotification400() {
        $raw = OneSignalService::singleton()->createNotification(Notification::create());
        $response = new NotificationResponse($raw);

        $this->assertTrue($response->isError());
    }
}
