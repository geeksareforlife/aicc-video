<?php

namespace Acorn\Providers;

interface VideoInterface
{
	public function getName();

	public function canHandleVideo($videoURL);

	public function loadVideo();

	public function getVideoId();

	public function getTitle();

	public function getDuration();

	public function getServiceJavascriptURIs();
}