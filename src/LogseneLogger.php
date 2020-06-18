<?php
namespace Logger;

use Logger\HttpClientAdapters\LogseneCurlHttpClientAdapter;
use Logger\HttpClientAdapters\LogseneHttpClientAdapter;
use Psr\Log\AbstractLogger;
use Throwable;

if(!defined('JSON_THROW_ON_ERROR')) {
	define('JSON_THROW_ON_ERROR', 4194304);
}

class LogseneLogger extends AbstractLogger {
	/** @var string */
	private $logseneUrl;
	/** @var LogseneHttpClientAdapter */
	private $httpClientAdapter;
	/** @var array */
	private $tags;
	/** @var array */
	private $context;

	/**
	 * @param string $logseneUrl
	 * @param array $tags
	 * @param array $context
	 * @param LogseneHttpClientAdapter $httpClientAdapter
	 */
	public function __construct(string $logseneUrl, array $tags = [], array $context = [], LogseneHttpClientAdapter $httpClientAdapter = null) {
		$this->logseneUrl = $logseneUrl;
		$this->tags = $tags;
		$this->httpClientAdapter = $httpClientAdapter ?? new LogseneCurlHttpClientAdapter();
		$this->context = $context;
	}

	/**
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 */
	public function log($level, $message, array $context = []) {
		$data = [
			'severity' => $level,
			'tags' => $this->getTags($context),
			'message' => $message,
			'context' => array_merge($this->context, $context)
		];

		try {
			$body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
			$this->httpClientAdapter->post($this->logseneUrl, $body, []);
		} catch (Throwable $e) {
		}
	}

	/**
	 * @param array $context
	 * @return array
	 */
	private function getTags(array $context) {
		$tags = $context['logsene-tags'] ?? null;
		$tags = $tags ?? $context['tags'] ?? [];
		$result = [];
		if(is_array($tags)) {
			foreach($tags as $tag) {
				if(is_scalar($tag)) {
					$result[] = $tag;
				}
			}
		}
		foreach($this->tags as $tag) {
			$result[] = $tag;
		}
		$result = array_unique($result, SORT_STRING);
		return $result;
	}
}
