<?php
require "../common.php";

/**
 * Builds the actual AICC package
 *
 * The package is built from three sources:
 * - The Base package - this includes all the AICC bumph
 * - The Template - this is the look and feel and is compiled through Twig (if necessary)
 *     Template files can override files in the Base package if they wish
 * - The Provider files - this includes a service-specific javascript
 */

// create temp directory


// copy base package to temp


// copy any plain template files to temp


// process template files and output to temp


// copy provider files to temp


// Zip up files and return to user - delete unzipped files


dump($_POST);