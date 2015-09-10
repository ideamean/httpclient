#!/usr/bin/env php
<?php
// Merge all source files
$update = date('Y/m/d H:i:s');
$comment = <<<EOF
<?php
/**
 * A parallel HTTP client written in pure PHP
 *
 * This file was generated by script at: {$update}
 *
 * @author hightman <hightman@twomice.net>
 * @link http://hightman.cn
 * @copyright Copyright (c) 2015 Twomice Studio.
 */

namespace hightman\\http;

EOF;

echo 'Scanning source files ...', PHP_EOL;
$content = '';
$files = glob('src/*.php');
sort($files);
foreach ($files as $file) {
    $content .= "\n" . file_get_contents($file);
}
echo 'OK, total files: ', count($files), ', total bytes: ', number_format(strlen($content)), PHP_EOL;
echo 'Stripping unused comments and blank line ...', PHP_EOL;
$content = preg_replace('/^(\?>|<\?php).*$/m', '', $content);
$content = preg_replace('/^namespace .*$/m', '', $content);
$content = preg_replace('#(?<!\*)/\*.+?\*\/#s', '', $content);
$content = preg_replace('#(?<![\\\\:])//.*$#m', '', $content);
$content = preg_replace("/[\r\n]+[\s\t]*[\r\n]+/", "\n", $content);
$content = preg_replace("/^[\s\t]*[\r\n]+/", "", $content);
echo 'OK, result bytes: ', number_format(strlen($content)), PHP_EOL;
echo 'Saving to output file ...', PHP_EOL;
file_put_contents('httpclient-dist.php', $comment . $content);
echo 'OK.', PHP_EOL;
