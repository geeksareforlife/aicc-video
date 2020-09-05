<?php

namespace GeeksAreForLife\AiccVideo;

class Template
{

    private $config;

    private $directory;
    private $directoryName;
    private $name;

    private $twig;

    private $tempDir;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->directoryName = str_replace(TEMPLATES . '/', '', $directory);

        $this->config = json_decode(file_get_contents($directory . '/template.json'), true);

        $this->name = $this->config['name'];

        $loader = new \Twig_Loader_Filesystem($directory);
        $this->twig = new \Twig_Environment($loader, array(
            'auto_reload' => true,
        ));
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getDirectoryName()
    {
        return $this->directoryName;
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
        $this->tempDir = $tempDir;
        dump($this->tempDir);

        // Get package files
        // template files overwrite the base package files
        $files = array_merge(getTemplateFiles(BASE_PACKAGE), getTemplateFiles($this->getDirectory()));

        $templateVariables = $this->getVariables($videoid, $provider, $title, $checkpoints);

        dump($files);
        foreach ($files as $relative => $file) {
            /*$extension = pathinfo($file, PATHINFO_EXTENSION);

            if ($extension == "twig") {
                // compile and place into file
                $compiled = $this->twig->render($relative, $templateVariables);

                // trim the twig extension
                $filename = substr($relative, 0, -5);

                file_put_contents($this->tempDir . $filename, $compiled);
            } else {
                // copy the file to the tmp dir
                copyFile($file, $this->tempDir . $relative);
            }*/
        }
    }

    public function zipAndReturn()
    {
        // Zip up files and return to user
    }

    public function removeTempFiles()
    {
        $this->removeTempDir($this->tempDir);
    }

    private function removeTempDir($directory)
    {
        if (strpos($directory, TMP) === FALSE) {
            throw new Exception("Attmept to remove a non temp directory! " . $directory, 1);
            die; 
        }

        $dir = opendir($directory);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $directory . '/' . $file;
                if ( is_dir($full) ) {
                    $this->removeTempDir($full);
                }
                else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($directory);
    }

    private function getVariables($videoid, $provider, $title, $checkpoints)
    {
        $variables = [
            'videoid'       => $videoid,
            'title'         => $title,
            'checkpoints'   => $checkpoints,
        ];

        return $variables;
    }
}
