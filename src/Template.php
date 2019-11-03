<?php

namespace GeeksAreForLife\AiccVideo;

class Template
{

    private $config;

    private $directory;
    private $name;

    public function __construct($directory)
    {
        $this->directory = str_replace(TEMPLATES . '/', '', $directory);

        $this->config = json_decode(file_get_contents($directory . '/template.json'), true);

        $this->name = $this->config['name'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Builds the actual AICC package
     *
     * The package is built from three sources:
     * - The Base package - this includes all the AICC bumph
     * - The Template - this is the look and feel and is compiled through Twig (if necessary)
     *     Template files can override files in the Base package if they wish
     * - The Provider files - this includes a service-specific javascript
     */
    public function process($tempDir, $videoid, $provider, $title, $checkpoints)
    {
        // Get base package files
        $files = getBaseFiles();

        // get any plain template files
        

        // get provider files
        

        // copy files to temp
        var_dump($files);
        /*copyFiles($files, $tempDir);*/

        // process template files and output to temp


        // Zip up files and return to user - delete unzipped files
    }
}
