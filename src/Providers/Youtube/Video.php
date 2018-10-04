<?php

namespace Acorn\Providers\Youtube;

use Acorn\Providers\VideoInterface;

class Video
{

	public function __construct()
	{

	}

	public function getName()
	{
		return "YouTube";
	}

	public function canHandleVideo($videoURL)
	{

		return false;
	}
}