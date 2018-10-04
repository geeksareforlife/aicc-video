<?php

function redirect($location) {
	$locations = [
		'index'	=>	'/index.php',
	];

    if (isset($locations[$location])) {
        header("Location: " . $locations[$location]);
        die();
    }
}

function formatDuration($seconds)
{
	if ($seconds < 60) {
		return "00:" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
	}

	$minutes = floor($seconds / 60);
	$seconds = $seconds % 60;

	if ($minutes < 60) {
		return str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
	} else {
		$hours = floor($minutes / 60);
		$minutes = $minutes % 60;

		return $hours . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
	}
}