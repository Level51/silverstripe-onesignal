<?php

namespace Level51\OneSignal;

class Notification
{

    const DEFAULT_SEGMENT = 'All';

    /**
     * @see https://documentation.onesignal.com/docs/language-localization#what-languages-are-supported
     */
    const SUPPORTED_LOCALES = [
        'en',
        'ar',
        'ca',
        'zh-Hans',
        'zh-Hant',
        'hr',
        'cs',
        'da',
        'nl',
        'et',
        'fi',
        'fr',
        'ka',
        'bg',
        'de',
        'el',
        'hi',
        'he',
        'hu',
        'id',
        'it',
        'ja',
        'ko',
        'lv',
        'lt',
        'ms',
        'nb',
        'fa',
        'pl',
        'pt',
        'ro',
        'ru',
        'sr',
        'sk',
        'es',
        'sv',
        'th',
        'tr',
        'uk',
        'vi'
    ];

    private $segments;

    private $contents;

    private $headings;

    private $data;

    public function __construct()
    {
        $this->segments = [self::DEFAULT_SEGMENT];
        $this->contents = [];
        $this->headings = [];
        $this->data = [];
    }

    public static function create()
    {
        return new self();
    }

    private function isSupportedLocale($locale)
    {
        return in_array($locale, self::SUPPORTED_LOCALES);
    }

    /**
     * @param $locale
     * @param $content
     *
     * @return $this
     * @throws OneSignalException
     */
    public function addContent($locale, $content)
    {
        if (!$this->isSupportedLocale($locale)) {
            throw new OneSignalException("'$locale' is not a supported locale.");
        }

        $this->contents[$locale] = $content;

        return $this;
    }

    /**
     * @param $locale
     * @param $heading
     *
     * @return $this
     * @throws OneSignalException
     */
    public function addHeading($locale, $heading)
    {
        if (!$this->isSupportedLocale($locale)) {
            throw new OneSignalException("'$locale' is not a supported locale.");
        }

        $this->headings[$locale] = $heading;

        return $this;
    }

    public function addData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function forSegment($segment)
    {
        $this->segments = [$segment];

        return $this;
    }

    public function toArray()
    {
        return [
            'included_segments' => $this->segments,
            'contents'          => $this->contents,
            'headings'          => $this->headings,
            'data'              => $this->data
        ];
    }
}
