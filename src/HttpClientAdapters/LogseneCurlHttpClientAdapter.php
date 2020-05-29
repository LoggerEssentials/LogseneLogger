<?php
namespace Logger\HttpClientAdapters;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class LogseneCurlHttpClientAdapter implements LogseneHttpClientAdapter {
	/**
	 * @param string $uri
	 * @param string $postData
	 * @param array $headers
	 * @throws \JsonException
	 * @throws ClientExceptionInterface
	 */
	public function post(string $uri, string $postData, array $headers) {
		$ch = curl_init();
		try {
			curl_setopt_array($ch, [
				CURLOPT_URL => $uri,
				CURLOPT_POSTFIELDS => $postData,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
			]);
			curl_exec($ch);
		} finally {
			curl_close($ch);
		}
	}
}
