<?php

namespace Level51\OneSignal;

use SilverStripe\Dev\SapphireTest;

class NotificationTest extends SapphireTest
{

    public function testCreate()
    {
        $this->assertEquals(Notification::class, get_class(Notification::create()));
    }

    public function testToArray()
    {
        $notification = Notification::create();

        $this->assertEquals([
            'included_segments' => [Notification::DEFAULT_SEGMENT],
            'contents'          => [],
            'headings'          => [],
            'data'              => []
        ], $notification->toArray());
    }

    public function testUnsupportedLocale()
    {
        $locale = 'unsupportedlocale';
        $content = 'Test Content 1';

        $this->expectException(OneSignalException::class);
        $this->expectExceptionMessage("'$locale' is not a supported locale.");

        Notification::create()->addContent($locale, $content);
    }

    public function testAddContent()
    {
        $locale = 'de';
        $content = 'Test Content 1';
        $payload = Notification::create()->addContent($locale, $content)->toArray();

        $this->assertEquals([
            $locale => $content
        ], $payload['contents']);
    }

    public function testAddHeading()
    {
        $locale = 'de';
        $subject = 'Test Heading 1';
        $payload = Notification::create()->addHeading($locale, $subject)->toArray();

        $this->assertEquals([
            $locale => $subject
        ], $payload['headings']);
    }

    public function testAddData()
    {
        $key1 = 'testkey1';
        $val1 = 'Test Value 1';
        $key2 = 'testkey2';
        $val2 = ['testvalue2', 'testvalue3'];

        $payload = Notification::create()
            ->addData($key1, $val1)
            ->addData($key2, $val2)
            ->toArray();

        $this->assertEquals([
            $key1 => $val1,
            $key2 => $val2
        ], $payload['data']);
    }

    public function testForSegment()
    {
        $testSegment = 'Test Segment';
        $notification = Notification::create();

        $this->assertEquals([Notification::DEFAULT_SEGMENT], $notification->toArray()['included_segments']);
        $this->assertEquals([$testSegment], $notification->forSegment($testSegment)->toArray()['included_segments']);
    }
}
