<?php
require "../common.php";

use GeeksAreForLife\AiccVideo\Template;

$template = new Template(TEMPLATES . '/' . $_POST['template']);

// create temp directory
$tempDir = getTempDirectory();
while (file_exists($tempDir)) {
    $tempDir = getTempDirectory();
}
dump($tempDir);
if (!mkdir($tempDir)) {
    throw new \Exception("Unable to create temp directory " . $tempDir, 1);
    
}

$template->process($tempDir, $_POST['videoid'], $_POST['provider'], $_POST['videoTitle'], $_POST['checkpoints']);

$template->zipAndReturn();

//$template->removeTempFiles();