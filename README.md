# Remi 🐕 - Remote Image

Remi is a WordPress plugin designed to streamline the local development process. It works by swapping the URLs of the images, making it easier to work locally by loading the images from the live URL.

## Features

- **URL Swapping**: Remi can replace the URLs of images, by changing the `<img>` src to point to the live url instead of the local url. This is particularly useful when the website has a lot of images and downloading them in bulk takes a long time.

- **Selective Downloading**: Instead of downloading all images from the live site, Remi allows you to download only the images needed for local development. This can significantly speed up the setup process and save disk space. On page load all the `<img>` src will be swapped to the live url but the image will also be downloaded to the local sites uploads folder. On the next page reload the newly downloaded files will be served instantly.

## How to Use

1. Install & Activate the plugin in WordPress.
2. Navigate to the Remi settings page under Tools.
3. Specify the live site URL and the local site URL.
4. Enable remote image swapping. The plugin and it will start swapping the URLs of the images.
5. Enable remote image downloading and the plugin will start downloading the remote images to the local uploads directory. On the next page load it will use the local images that have been downloaded instead of the remote url.

## Requirements

- PHP 7.4 or higher
- WordPress 5.6 or higher

## Contributing

We welcome contributions from the community. If you'd like to contribute, please fork the repository and submit a pull request.

## Author

This plugin is developed by [SKYCATCHFIRE](https://www.skycatchfire.com/).

## License

Remi is open-source software licensed under the MIT license.

_In loving memory of a fluffy cat sized dog._
