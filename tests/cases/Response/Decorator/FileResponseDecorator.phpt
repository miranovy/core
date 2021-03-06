<?php declare(strict_types = 1);

/**
 * Test: Response\Decorator\FileResponseDecorator
 */

require_once __DIR__ . '/../../../bootstrap.php';

use Apitte\Core\Response\Decorator\FileResponseDecorator;
use Contributte\Psr7\Psr7ResponseFactory;
use Tester\Assert;

test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();
	$decorator = new FileResponseDecorator();

	$response = $decorator->decorate($response, $response->getBody(), 'filename');

	Assert::same(
		[
			'Content-Type' => ['application/octet-stream'],
			'Content-Description' => ['File Transfer'],
			'Content-Transfer-Encoding' => ['binary'],
			'Content-Disposition' => ['attachment; filename="filename"; filename*=utf-8\'\'filename'],
			'Expires' => ['0'],
			'Cache-Control' => ['must-revalidate, post-check=0, pre-check=0'],
			'Pragma' => ['public'],
			'Content-Length' => ['0'],
		],
		$response->getHeaders()
	);
});
