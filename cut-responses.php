<?php

$files = scandir('html-responses/');

unset($files[0], $files[1], $files[2]);

for ($n = 5, $i = 0; $n <= 30000; $n += 5, $i++)
{
	$index = sprintf('%05d', $i);
	$key = array_rand($files);
	$file = 'html-responses/'.$files[$key];

	$data = substr(file_get_contents($file), 0, $n);

	file_put_contents("html-responses/fabricated-{$index}.html", $data);

	echo "html-responses/fabricated-{$index}.html\n";
}
