# Silverstripe OneSignal

[![Build Status](https://travis-ci.com/Level51/silverstripe-onesignal.svg?branch=develop)](https://travis-ci.com/Level51/silverstripe-onesignal)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Silverstripe module wrapper for OneSignal PHP SDK.

Provides a class `OneSignalService` for creating/sending notifications.
Use convenience classes `Notification` and `NotificationResponse` for handling request and response payload.

## Requirements

- Silverstripe ^4.0
- OneSignal PHP SDK `norkunas/onesignal-php-api`
- PSR-18 HTTP client (e.g. `symfony/http-client`)
- PSR-17 HTTP factories (e.g. `nyholm/psr7`)

## Installation

```
composer require level51/silverstripe-onesignal
```

## Documentation

The module is based on the [OneSignal API for PHP](https://github.com/norkunas/onesignal-php-api).

At the moment, only the Notifications API is being used.

This project adheres PSR-2.

### Config

Two env vars and one config value are mandatory when initializing `OneSignalService`.
`OneSignalException` is thrown if not configured properly.

#### Environment

Define the following vars in your `.env` file.

- `ONESIGNAL_AUTH_KEY` (defined on account/profile level)
- `ONESIGNAL_APP_AUTH_KEY`

Since the auth keys are sensitive data, it's recommended to not have them included in any VCS.

#### Config API

- `app_id`

Example:

```yml
Level51\OneSignal\OneSignalService:
  app_id: 'xxxxxx-0000-xxxx-0000-xxxxxxxxxx'
```

### Usage

Send a simple notification.

```php
try {
    $notification = Notification::create()
        ->addHeading('en', 'My first notification')
        ->addContent('en', 'Yay, my Silverstripe app created this')
        ->addData('myVar', 'foo');

    $response = OneSignalService::singleton()->createNotification($notification);
    if (!$response->isError()) {
        echo 'Notification with id ' . $response->getId() . ' was sent to ' . $response->getRecipientsCount() . ' recipients';
    }
} catch (OneSignalException $e) {}
```

Make sure to provide a [supported locale](https://documentation.onesignal.com/docs/language-localization#what-languages-are-supported) for `addHeading()` and `addContent()`.

## Maintainer

- Julian Scheuchenzuber <js@lvl51.de>
