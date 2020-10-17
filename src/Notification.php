<?php

namespace Level51\OneSignal;

class Notification {

    const DEFAULT_SEGMENT = 'All';

    private $segments;

    private $contents;

    private $data;

    public function __construct() {
        $this->segments = [self::DEFAULT_SEGMENT];
        $this->contents = [];
        $this->data = [];
    }

    public static function create() {
        return new self();
    }

    public function addContent($locale, $content) {
        $this->contents[$locale] = $content;

        return $this;
    }

    public function addData($key, $value) {
        $this->data[$key] = $value;

        return $this;
    }

    public function forSegment($segment) {
        $this->segments = [$segment];

        return $this;
    }

    public function toArray() {
        return [
            'included_segments' => $this->segments,
            'contents'          => $this->contents,
            'data'              => $this->data
        ];
    }
}
