<?php

namespace Acorn\Providers;

class Factory
{
	final public static function loadProvider($providerName, &$config)
	{
		$class = 'Acorn\\Providers\\' . $providerName . '\\Video';

		// TODO: check class exists here

		return new $class($config);
	}
}