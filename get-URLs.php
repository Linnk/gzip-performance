<?php

$urls = explode(PHP_EOL, file_get_contents('unique-URLs.txt'));

foreach ($urls as $index => $url)
{
	$index = sprintf('%03d', $index);

	if (strpos($url, 'http') !== 0)
	{
		continue;
	}

	exec("wget --load-cookies ~/Downloads/cookies.txt --save-headers -O html-responses/response-{$index}.html {$url}");

	$response = file_get_contents("html-responses/response-{$index}.html");
	if (strpos($response, '<title>Incrementa — Ingresar</title>'))
	{
		echo "\n\n Session lost at response-{$index}.html \n\n";
		break;
	}
}
// exec('wget --load-cookies ~/Downloads/cookies.txt --save-headers -O html-responses/test.html http://incrementacrm.com/dashboard');

// var_dump($output);
