<?php
namespace Logger\HttpClientAdapters;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class LogseneClientInterfaceHttpClientAdapter implements LogseneHttpClientAdapter {
	/** @var ClientInterface */
	private $httpClient;
	/** @var RequestFactoryInterface */
	private $requestFactory;
	/** @var StreamFactoryInterface */
	private $streamFactory;

	public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory) {
		$this->httpClient = $httpClient;
		$this->requestFactory = $requestFactory;
		$this->streamFactory = $streamFactory;
	}

	/**
	 * @param string $uri
	 * @param string $postData
	 * @param array $headers
	 * @throws \JsonException
	 * @throws ClientExceptionInterface
	 */
	public function post(string $uri, string $postData, array $headers) {
		$request = $this->requestFactory->createRequest('POST', $uri);
		$stream = $this->streamFactory->createStream($postData);
		$request = $request->withBody($stream);
		$response = $this->httpClient->sendRequest($request);
		$response->getBody();
	}
}
