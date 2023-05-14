# simple-short-url

I wanted to discontinue my [YOURLS](https://github.com/YOURLS/YOURLS) URL shortener but still keep all existing links intact.

## Usage

1. Delete all YOURLS files from your webserver, except `/user/config.php`! (or use the provided `/user/config-sample.php` file) 
2. Upload the `index.php` and `.htaccess` file to your webserver. 
3. Optional: you can delete the `log` and `option` table from MySQL, but keep the `url` table.
