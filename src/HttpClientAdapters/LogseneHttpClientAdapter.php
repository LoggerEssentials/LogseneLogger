<?php
namespace Logger\HttpClientAdapters;

interface LogseneHttpClientAdapter {
	/**
	 * @param string $uri
	 * @param string $postData
	 * @param array $headers
	 * @return void
	 */
	public function post(string $uri, string $postData, array $headers);
}
