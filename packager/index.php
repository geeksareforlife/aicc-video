<?php
require "../common.php";

if (!isset($_POST['video']) || $_POST['video'] ==  "") {
	// redirect to index
	redirect("index");
}

$provider = false;
foreach ($providers as $checkProvider) {
	if ($checkProvider->canHandleVideo($_POST['video'])) {
		$provider = $checkProvider;
	}
}

// we don't don't have a provider that can handle this URL
if (!$provider) {
	echo $twig->render('errors/no-provider.twig', ['video' => $_POST['video']]);
	die;
}

if ($provider->loadVideo()) {
	$video = [
		'id'	=> $provider->getVideoId(),
		'title' => $provider->getTitle(),
		'duration' => formatDuration($provider->getDuration()),
	];
} else {
	$video = [
		'id'	=> $provider->getVideoId(),
		'title' => false,
		'duration' => false,
	];
}



$providerDetails = [
	'name'		=> $provider->getName(),
	'scripts'	=> $provider->getServiceJavascriptURIs(),
];

echo $twig->render('packager/index.twig', ['video' => $video, 'provider' => $providerDetails, 'templates' => getTemplates()]);