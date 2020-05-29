# LogseneLogger
A logger for Logsene

## Installation

```
composer require logger/logsene
```

## Example configuration

```php
$url = "https://logsene-receiver.eu.sematext.com/66260a29-f1cc-4121-8b24-058587ba0a80/test/";
$tags = ['test'];
$context = ['test' => true];
$httpClientAdapter = null; /// Use the default http-client-adapter
$logger = new \Logger\LogseneLogger($url, $tags, $context, $httpClientAdapter);
$logger->debug('This is a test-message');
```
