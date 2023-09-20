# BrowserDetector

[![Latest Stable Version](https://poser.pugx.org/mimmi20/browser-detector/v/stable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![Latest Unstable Version](https://poser.pugx.org/mimmi20/browser-detector/v/unstable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![License](https://poser.pugx.org/mimmi20/browser-detector/license?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)

## Code Status

[![codecov](https://codecov.io/gh/mimmi20/BrowserDetector/branch/master/graph/badge.svg)](https://codecov.io/gh/mimmi20/BrowserDetector)
[![Average time to resolve an issue](https://isitmaintained.com/badge/resolution/mimmi20/BrowserDetector.svg)](https://isitmaintained.com/project/mimmi20/BrowserDetector "Average time to resolve an issue")
[![Percentage of issues still open](https://isitmaintained.com/badge/open/mimmi20/BrowserDetector.svg)](https://isitmaintained.com/project/mimmi20/BrowserDetector "Percentage of issues still open")

## Requirements

This library requires PHP 8.1+.
Also a PSR-3 compatible logger and a PSR-16 compatible cache are required.

## Installation

Run the command below to install via Composer

```shell
composer require mimmi20/browser-detector
```

## Usage

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

// get the result
$result = $detector->getBrowser($request);
```

The request parameter may be a string, an array or a PSR-7 compatible message.

## Usage Examples

### Taking the user agent from the global $_SERVER variable

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

$result = $detector->getBrowser($_SERVER);
```

### Using a sample useragent

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

$result = $detector->getBrowser($the_user_agent);
```

## The result

The `getBrowser` function returns an array with this structure

```php
[
    'headers' => [],
    'device' => [
        'architecture' => null,
        'deviceName' => null,
        'marketingName' => null,
        'manufacturer' => null,
        'brand' => null,
        'dualOrientation' => null,
        'simCount' => null,
        'display' => [
            'width' => null,
            'height' => null,
            'touch' => null,
            'size' => null,
        ],
        'type' => null,
        'ismobile' => null,
        'istv' => null,
        'bits' => null,
    ],
    'os' => [
        'name' => null,
        'marketingName' => null,
        'version' => null,
        'manufacturer' => null,
    ],
    'client' => [
        'name' => null,
        'modus' => null,
        'version' => null,
        'manufacturer' => null,
        'type' => null,
        'isbot' => null,
    ],
    'engine' => [
        'name' => null,
        'version' => null,
        'manufacturer' => null,
    ],
]
```

## Issues and feature requests

Please report your issues and ask for new features on the GitHub Issue Tracker
at https://github.com/mimmi20/BrowserDetector/issues
