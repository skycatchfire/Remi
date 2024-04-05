# Fire Image Proxy

Fire Image Proxy is a WordPress plugin designed to streamline your local development process. It works by swapping the URLs of your images, making it easier to work with your local setup.

## Features

- **URL Swapping**: Fire Image Proxy can replace the URLs of your images, by changing the `<img>` src to point to the live url instead of your local url. This is particularly useful when your website has a lot of images and downloading them in bulk takes a long time.

- **Selective Downloading**: Instead of downloading all images from your live site, Fire Image Proxy allows you to download only the images you need for your local development. This can significantly speed up your setup process and save disk space. On page load Your `<img>` scr will be swapped to your live url but the image will also be downloaded to your local sites uploads folder. On the next page reload you will be served your newly downloaded files instantly.

## How to Use

1. Install & Activate the plugin in your WordPress setup.
2. Navigate to the Fire Image Proxy settings page under Tools.
3. Specify the URL of your live site and the URL of your local site.
4. Toggle load remote images to on. The plugin and it will start swapping the URLs of your images.
5. Enable Image Downloads and the plugin will start downloading the remote images to your local setup. On the next page load it will use your local images that have been downloaded instead of the remote url.

## Requirements

- PHP 7.4 or higher
- WordPress 5.6 or higher

## Contributing

We welcome contributions from the community. If you'd like to contribute, please fork the repository and submit a pull request.

## Author

This plugin is developed by [SKYCATCHFIRE](https://www.skycatchfire.com/).

## License

Fire Image Proxy is open-source software licensed under the MIT license.
