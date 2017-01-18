# GZIP impact performance on NGINX

Honestly, this is a small and kind of poorly research about the performance of using GZIP with NGINX, for educational purposes. I did this to demonstrate more or less the server behaviour to my team at [Incrementa](https://incrementacrm.com/).

The expirement consisted in figuring out the best value for **gzip_min_length** at *nginx.conf* and demonstrate that small files aren't worth of compression time.

**1. Generating the data**

First, I recopiled all the most common GET request at our app using `tail -n 20000 access.log | grep -o "GET [^ ]*" | sort | uniq > unique-URLs.txt`

Using atom editor I replace all the first "GET " with "http://".

**2. Downloading samples**

I used wget to download every request content including headers. So I wrote a simple script `get-URLs.php` that will do this for every URL at `unique-URLs.txt`

**3. Generating more samples**

I wanted even more cases, so I wrote another script that will choose random html reponses from the previous step and I will cut the size incrementally. This way I will have files starting at the irreal size of 5 bytes. It's totally irreal, because the headers lenght is way more than 5 bytes, but again, I did it with educational purposes.

**3. Processing data**

I wrote another script `zip-responses.php` that scans the html-responses/ folder and compress every file there, while saving size and time consumed using `gzip` command. All the data generated is store in a `stats.txt` with CSV format.

**4. Reading the results**

Finally, open index.html. You will need a local web server, because the data is requested using AJAX. As it becomes evident with my results `gzip-performance.jpg`, the irreal small files are worthless of compression.

Some other observations:

* Less than 200 bytes gzip can even make the file bigger.
* Less than 2,000 bytes takes half a second. Not worth it.
* Less than 3,000 bytes is still slow and compression ratio is about 0.5
* At 3,000 bytes is still slow and compression ratio is about 0.5
* At 9,000 bytes the compression ratio is about 0.21 and it takes 0.2 seconds.

Anything less than 9 Kilobytes are not worth of gzip, the time wasted in compression could probably be used in transfer. Nginx servers have a default set **gzip_min_length** to 256 bytes, which obviously will not be the best configuration for small responses, unless your priority is to really reduce transfer consumtion.

That's it. Just a quick —and probably bad designed— gzip experiment with educational purposes.

Bye.
