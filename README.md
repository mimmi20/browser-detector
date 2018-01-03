# BrowserDetector

[![Latest Stable Version](https://poser.pugx.org/mimmi20/browser-detector/v/stable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![Latest Unstable Version](https://poser.pugx.org/mimmi20/browser-detector/v/unstable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![License](https://poser.pugx.org/mimmi20/browser-detector/license?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)

## Code Status

[![Build Status](https://travis-ci.org/mimmi20/BrowserDetector.svg?branch=master)](https://travis-ci.org/mimmi20/BrowserDetector)
[![codecov](https://codecov.io/gh/mimmi20/BrowserDetector/branch/master/graph/badge.svg)](https://codecov.io/gh/mimmi20/BrowserDetector)
[![Maintainability](https://api.codeclimate.com/v1/badges/cfb5e456908dbeb55112/maintainability)](https://codeclimate.com/github/mimmi20/BrowserDetector/maintainability)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/mimmi20/BrowserDetector.svg)](http://isitmaintained.com/project/mimmi20/BrowserDetector "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/mimmi20/BrowserDetector.svg)](http://isitmaintained.com/project/mimmi20/BrowserDetector "Percentage of issues still open")
[![Dependency Status](https://gemnasium.com/badges/github.com/mimmi20/BrowserDetector.svg)](https://gemnasium.com/github.com/mimmi20/BrowserDetector)


## Requirements

This library requires PHP 7.1+.
Also a PSR-3 compatible logger and a PSR-16 compatible cache are required.

## Installation

Run the command below to install via Composer

```shell
composer require mimmi20/browser-detector
```

## Preparation

Before you can use this library, you have to warmup the cache. This should be done not in the same process like the detection.

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$detector->warmupCache();
```

## Usage

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($request);
```

The request parameter may be a string, an array or a PSR-7 compatible message.

## Usage Examples

### Taking the user agent from the global $_SERVER variable

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($_SERVER);
```

### Using a sample useragent

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($the_user_agent);
```

## The result

The `getBrowser` function returns a [ua-result](https://github.com/mimmi20/ua-result) object.

## Issues and feature requests

Please report your issues and ask for new features on the GitHub Issue Tracker
at https://github.com/mimmi20/BrowserDetector/issues
