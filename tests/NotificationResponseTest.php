<?php

namespace Level51\OneSignal;

use SilverStripe\Dev\SapphireTest;

class NotificationResponseTest extends SapphireTest {

    /**
     * @var array
     * @see https://documentation.onesignal.com/reference/create-notification#results---create-notification
     */
    private $ok_payload = [
        'id'          => 'b98881cc-1e94-4366-bbd9-db8f3429292b',
        'recipients'  => 1,
        'external_id' => null
    ];

    public function testConstruct() {
        $raw = [];
        $response = new NotificationResponse($raw);

        $this->assertEquals(NotificationResponse::ACTION_CREATE, $response->getAction());
        $this->assertEquals($raw, $response->getRawResponsePayload());
    }

    public function testIsError() {
        $raw = [
            'errors' => [
                'contents must be key/value collections by language code'
            ]
        ];
        $response = new NotificationResponse($raw);

        $this->assertTrue($response->isError());
    }

    public function testId() {
        $response = new NotificationResponse($this->ok_payload);

        $this->assertEquals($this->ok_payload['id'], $response->getId());
    }

    public function testIdIsNull() {
        $raw = [];
        $response = new NotificationResponse($raw);

        $this->assertEquals(null, $response->getId());
    }

    public function testRecipientsCount() {
        $response = new NotificationResponse($this->ok_payload);

        $this->assertEquals($this->ok_payload['recipients'], $response->getRecipientsCount());
    }

    public function testRecipientsCount0() {
        $response = new NotificationResponse([]);

        $this->assertEquals(null, $response->getRecipientsCount());
    }
}
