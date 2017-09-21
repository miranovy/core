<?php

namespace Apitte\Core\Http;

use Apitte\Core\Exception\Logical\InvalidStateException;
use Apitte\Core\Schema\Endpoint;
use Contributte\Psr7\Extra\ExtraRequestTrait;
use Contributte\Psr7\Psr7RequestWrapper;

class ApiRequest extends Psr7RequestWrapper
{

	use ExtraRequestTrait;

	/**
	 * HELPERS *****************************************************************
	 */

	/**
	 * @return Endpoint
	 */
	public function hasEndpoint()
	{
		return $this->getAttribute(RequestAttributes::ATTR_ENDPOINT, NULL) !== NULL;
	}

	/**
	 * @return Endpoint
	 */
	public function getEndpoint()
	{
		return $this->getAttribute(RequestAttributes::ATTR_ENDPOINT);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasParameter($name)
	{
		return isset($this->getAttribute(RequestAttributes::ATTR_PARAMETERS, [])[$name]);
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParameter($name, $default = NULL)
	{
		if (!$this->hasParameter($name)) {
			if (func_num_args() < 2) {
				throw new InvalidStateException(sprintf('No parameter "%s" found', $name));
			}

			return $default;
		}

		return $this->getAttribute(RequestAttributes::ATTR_PARAMETERS)[$name];
	}

	/**
	 * @return mixed[]
	 */
	public function getParameters()
	{
		return $this->getAttribute(RequestAttributes::ATTR_PARAMETERS);
	}

}