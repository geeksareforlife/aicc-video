<?php

use GeeksAreForLife\AiccVideo\Template;

function redirect($location) {
    $locations = [
        'index' =>  '/index.php',
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

function getTemplates()
{
    $templates = [];

    foreach (new DirectoryIterator(TEMPLATES) as $fileInfo) {
        if ($fileInfo->isDot()) {
            continue;
        }
        
        if ($fileInfo->isDir() and file_exists($fileInfo->getPathname() . '/template.json')) {
            $templates[] = new Template($fileInfo->getPathname());
        }
    }

    return $templates;
}

function getTempDirectory()
{
    return TMP . '/' . substr(hash("sha256", microtime()), 0, 10);
}

function copyFiles($files, $destination)
{
    if (!file_exists($destination)) {
        if (!mkdir($destination)) {
            throw new \Exception("Unable to create temp directory " . $destination);
        }
    }

    foreach ($files as $source) {
        $filename = basename($source);
        copy($source, $destination . '/' . $filename);
    }
}