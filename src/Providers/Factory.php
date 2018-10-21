<?php

namespace GeeksAreForLife\AiccVideo\Providers;

class Factory
{
	final public static function loadProvider($providerName, &$config)
	{
		$class = 'GeeksAreForLife\\AiccVideo\\Providers\\' . $providerName . '\\Video';

		// TODO: check class exists here

		return new $class($config);
	}
}