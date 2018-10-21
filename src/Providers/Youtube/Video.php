<?php

namespace GeeksAreForLife\AiccVideo\Providers\Youtube;

use GeeksAreForLife\AiccVideo\Providers\VideoInterface;

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