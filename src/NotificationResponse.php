<?php

namespace Level51\OneSignal;

/**
 * Class NotificationResponse
 *
 * @see     https://documentation.onesignal.com/reference/create-notification#results---create-notification
 *
 * @package Level51\OneSignal
 */
class NotificationResponse {

    const ACTION_CREATE = 'create';

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $rawResponsePayload;

    /**
     * Notification response wrapper object.
     *
     * @param array       $raw Raw response payload
     * @param string|null $action
     */
    public function __construct(array $raw, $action = null) {
        if ($action === null) {
            $action = self::ACTION_CREATE;
        }

        $this->action = $action;
        $this->rawResponsePayload = $raw;
    }

    public function isError() {
        return !empty($this->rawResponsePayload['errors']);
    }

    public function getId() {
        return $this->rawResponsePayload['id'] ?? null;
    }

    public function getRecipientsCount() {
        return $this->rawResponsePayload['recipients'] ?? null;
    }

    public function getAction() {
        return $this->action;
    }

    public function getRawResponsePayload() {
        return $this->rawResponsePayload;
    }
}
