<?php
namespace Logger;

use Logger\HttpClientAdapters\LogseneMockHttpClientAdapter;
use PHPUnit\Framework\TestCase;

class LogseneLoggerTest extends TestCase {
	public function testLog() {
		$logseneUrl = 'https://logsene-receiver.eu.sematext.com/{appid}/logger/';
		$tags = ['test'];
		$context = ['test' => true];
		$httpClientAdapter = new LogseneMockHttpClientAdapter();
		$logger = new LogseneLogger($logseneUrl, $tags, $context, $httpClientAdapter);
		$logger->info('Hello World');
		$messages = $httpClientAdapter->getLogMessagesAndClear();

		$expectedResult = [
			'uri' => 'https://logsene-receiver.eu.sematext.com/{appid}/logger/',
			'postData' => '{"severity":"info","tags":["test"],"message":"Hello World","context":{"test":true}}',
			'headers' => []
		];
		$this->assertEquals([$expectedResult], $messages);
	}
}
