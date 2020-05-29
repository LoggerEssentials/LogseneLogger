<?php
namespace Logger\HttpClientAdapters;

class LogseneMockHttpClientAdapter implements LogseneHttpClientAdapter {
	/** @var array */
	private $messages = [];

	public function post(string $uri, string $postData, array $headers) {
		$this->messages[] = [
			'uri' => $uri,
			'postData' => $postData,
			'headers' => $headers
		];
	}

	public function getLogMessagesAndClear(): array {
		$messages = $this->messages;
		$this->messages = [];
		return $messages;
	}
}
