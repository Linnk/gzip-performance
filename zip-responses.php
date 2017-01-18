<?php

function microtime_float()
{
	list($usec, $sec) = explode(' ', microtime());

	return (float) $usec + (float) $sec;
}

$stats_file = 'stats.txt';
$files = scandir('files/');

unset($files[0], $files[1], $files[2]);

file_put_contents($stats_file, "SIZE,COMPRESSED,RATIO,TIME\n");

foreach ($files as $index => $file)
{
	if (strstr($file, '.gz'))
	{
		continue;
	}

	$before = microtime_float();
	exec("gzip -c files/{$file} > files/{$file}.gz");
	$after = microtime_float();

	$size = filesize("files/{$file}");
	$compress = filesize("files/{$file}.gz");
	$ratio = $size > 0 ? $compress / $size : '-1';
	$time = $after - $before;

	file_put_contents($stats_file, "{$size},{$compress},{$ratio},{$time}\n", FILE_APPEND);

	unlink("files/{$file}.gz");
	echo '.';
}

echo "\n";
