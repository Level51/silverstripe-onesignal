<?php

namespace Level51\OneSignal;

use SilverStripe\Dev\SapphireTest;

class OneSignalServiceTest extends SapphireTest {

    public function testCreateNotification400() {
        $response = OneSignalService::singleton()->createNotification(Notification::create());

        $this->assertTrue($response->isError());
    }
}
