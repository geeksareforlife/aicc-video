<?php

namespace Acorn\Providers\Vimeo;

use Acorn\Providers\VideoInterface;
use GuzzleHttp\Client;

class Video implements VideoInterface
{
	private $urlRegexes = [
		'/vimeo.com\/(\d*)/',
	];

	private $apiToken = '';
	private $httpClient = false;

	private $videoId = '';
	private $title;
	private $duration = 0;
	

	public function __construct(&$config)
	{
		// we are not going to store $config, get what we need
		$this->apiToken = $config->getValue('vimeo.token');
		if (!$this->apiToken || $this->apiToken == "") {
			throw new \Exception("No Vimeo token defined");
		}
	}

	public function getName()
	{
		return "Vimeo";
	}

	public function canHandleVideo($videoURL)
	{
		foreach ($this->urlRegexes as $regex) {
			if (preg_match($regex, $videoURL, $matches)) {
				$this->videoId = $matches[1];
				return true;
			}
		}
		return false;
	}

	public function loadVideo()
	{
		$client = $this->getHttpClient();

		$response = $client->request('GET', 'https://api.vimeo.com/videos/' . $this->videoId);

		$videoData = json_decode($response->getBody(), true);

		$this->title = $videoData['name'];
		$this->duration = $videoData['duration'];
	}

	public function getVideoId()
	{
		return $this->videoId;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getDuration()
	{
		return $this->duration;
	}

	public function getServiceJavascriptURIs()
	{
		$scripts = [];

		$scripts[] = "https://player.vimeo.com/api/player.js";

		$pathToFile = __DIR__ . "/service.js";

		if (strpos($pathToFile, $_SERVER['DOCUMENT_ROOT']) === false) {
			// doesn't seem to be in the served folder
			return false;
		} else {
			// make it relative
			$relative = str_replace($_SERVER['DOCUMENT_ROOT'], "", $pathToFile);

			// make sure the slashes are right
			$scripts[] = str_replace("\\", "/", $relative);
		}

		return $scripts;
	}

	private function getHttpClient()
	{
		if (!$this->httpClient) {
			$this->httpClient = new Client([
				'headers'	=> [
					'Authorization' => 'Bearer ' . $this->apiToken
				]
			]);
		}

		return $this->httpClient;
	}
}