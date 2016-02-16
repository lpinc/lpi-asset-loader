## LpiAssetLoader ZF2 Module

Created by [LPinc](http://livingpages.com/)

## Introduction

LpiAssetLoader is a Zend Framework 2 module that helps configure the loading of front-end _custom_ or _bower_ javascript and css files and assets.

This module can be especially handy if you need to load AMD javascript modules in your layouts or view scripts.

## Installation

#### via github

To install LpiAssetLoader, simply recursively clone this repository (`git clone
--recursive`) into your ZF2 modules directory.

#### Or with composer

1. Add this project and [LpiAssetLoader](https://github.com/lpinc/lpi-asset-loader) in your composer.json:

    ```json
    "require": {
        "lpinc/lpi-asset-loader": "~0.1"
    }
    ```

2. Now tell composer to download ZfcUser by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Enable

Enable __LpiAssetLoader__ in your `config/application.config.php` file.

#### Config Options

The LpiAssetLoader module has some options to help customize the basic functionality. After installing LpiAssetLoader, copy
`./vendor/lpinc/lpi-asset-loader/config/lpiassetloader.global.php.dist` to
`./config/autoload/lpiassetloader.global.php` and change the values as desired.

If you istalled dojo using bower, then a sample config might look like this:

    ```php
    $settings = array(
       'dojo_config_settings' => array(
          'async' => true,
          'parseOnLoad' => true
       ),
       'dojo_on' => true,
       'use_source' => true,
       'base_vendor_src_path' => '/bower_components/',
       'amd_vendor_modules' => array(
          'dojo' => 'dojo',
          'dijit' => 'dijit',
          'dojox' => 'dojox'
       )
    );

    return array(
       'lpi-asset-loader' => $settings
    );
    ```

## Example Uses:

### To configue and intialize dojo in a zend framework view-layout file:

    ```php
    if (is_object($this->LpiAssetLoader)) {
       echo $this->LpiAssetLoader->getDojoConfig();
       echo $this->LpiAssetLoader->getDojoInitAssets();
    }
    ```

### To configue dojo with a custom module in a zend framework layout file:
