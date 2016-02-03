<?php
// autoload the classes
require_once('src/autoloader.php');

use Gubler\StarGatherer\Fetcher;
use Gubler\StarGatherer\Converter;

$githubUser = $argv[1];
$outFile = $argv[2];

$fetcher = new Fetcher($githubUser);
$content = new Converter($githubUser);

file_put_contents($outFile, $content->convertToHtmlPage($fetcher->fetch()));

