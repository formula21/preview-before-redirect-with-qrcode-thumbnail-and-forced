# Preview URL with QR Code and Thumbnail

Plugin for [YOURLS](http://yourls.org) `1.5+`. Tested on YOURLS 1.8.1

Description
-----------
1. Add the character '~' to a short URL to display a preview page with QR code and Thumbnail image before redirection.
2. On clicking a shortlink, land on a preview page, and wait for `N` seconds before auto redirection.

Requirements
-----------
The following plugins should already be installed and activated:
1. [YOURLS QRCode](https://github.com/seandrickson/YOURLS-QRCode-Plugin) or [Google Chart API QR Code Plugin](https://github.com/YOURLS/YOURLS/wiki/Plugin-%3D-QRCode-ShortURL). If not found, an `QR NOT FOUND` image is displayed`
2. [Thumbnail URL image](https://github.com/prog-it/yourls-thumbnail-url). If not found Preview Not Found image is displayed.

Installation
------------
1. In `/user/plugins`, create a new folder named `preview-url-with-qrcode-thumbnail`.
2. Drop these files in that directory.
3. Go to `/user/config.php` and add:
   - `define('PRE_REDIRECT_PREVIEW', true);` to activate the preview before redirect plugin.
   - `define('PRE_REDIRECT_SECONDS', 10);` to define the number of seconds before auto-redirection. Recommended **8 to 10** seconds.
   - These features are optional.
   - The plugin is so made to replace with the `long url` if Javascript is active. If not, the plugin yet works and will redirect with something called a `Refresh` header.
5. Go to the Plugins administration page ( *eg* `http://sho.rt/admin/plugins.php` ) and activate the plugin.
6. Have fun!

Translating
-----------
This plugin already translated to English and Russian, simply uses whatever language YOURLS uses, as described [here](https://github.com/YOURLS/YOURLS/wiki/YOURLS-in-your-language#install-yourls-in-your-language).

If you want to translate this plugin into your own language, [this blog post](http://blog.yourls.org/2013/02/workshop-how-to-create-your-own-translation-file-for-yourls/) from YOURLS describes how to do it. You can find the latest .pot file in the `languages` folder of the plugin directory. Please follow the contributing guidelines below to add your translation to plugin.


License
-------
MIT License
