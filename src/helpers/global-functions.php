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

function copyFile($source, $destination)
{
    if (!file_exists($destination)) {
        if (!file_exists(basename($destination)) && !mkdir(basename($destination))) {
            throw new \Exception("Unable to create directory " . basename($destination));
        }
    } else {
        throw new \Exception("Cannot copy file into package as it already exists " . $destination, 1);
        
    }

    return copy($source, $destination);

}

function getTemplateFiles($directory)
{
    $files = getFileList($directory);

    // process into an array with relative keys
    $returnFiles = [];
    foreach ($files as $file) {
        $key = str_replace($directory, "", $file);
        $returnFiles[$key] = $file;
    }
    return $returnFiles;
}

function getFileList($directory, $recursive = true)
{
    $files = [];

    foreach (new DirectoryIterator($directory) as $fileInfo) {
        if ($fileInfo->isDot()) {
            continue;
        }

        if ($fileInfo->isDir() && $recursive == true) {
            $files = array_merge($files, getFileList($fileInfo->getPathname(), $recursive));
        }

        $files[] = $fileInfo->getPathname();

    }

    return $files;
}