BrowserDetector
===============

Requirements
------------

This library requires PHP 7.0+.
Also a PSR-3 compatible logger and a PSR-6 compatible cache are required.

Installation
------------

Run the command below to install via Composer

```shell
composer require mimmi20/browser-detector
```

Usage
-----

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($request);
```

The request parameter may be a string, an array or a \Wurfl\Request\GenericRequest instance. PSR-7 compatible messages are not supported yet.

Usage Examples
--------------

## Taking the user agent from the global $_SERVER variable

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($_SERVER);
```

## Using a sample useragent

```php
$detector = new \BrowserDetector\Detector($cache, $logger);

$result = $detector->getBrowser($the_user_agent);
```

The result
----------

The `getBrowser` function returns a [ua-result](https://github.com/mimmi20/ua-result) object.

Project status
--------------

[![Latest Stable Version](https://poser.pugx.org/mimmi20/browser-detector/v/stable)](https://packagist.org/packages/mimmi20/browser-detector)
[![Latest Unstable Version](https://poser.pugx.org/mimmi20/browser-detector/v/unstable)](https://packagist.org/packages/mimmi20/browser-detector)
[![License](https://poser.pugx.org/mimmi20/browser-detector/license)](https://packagist.org/packages/mimmi20/browser-detector)

[![Build Status](https://api.travis-ci.org/mimmi20/BrowserDetector.png?branch=master)](https://travis-ci.org/mimmi20/BrowserDetector)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mimmi20/BrowserDetector/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mimmi20/BrowserDetector/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mimmi20/BrowserDetector/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mimmi20/BrowserDetector/?branch=master)

[![Dependency Status](https://www.versioneye.com/user/projects/588d13bfc64626004e05797a/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/588d13bfc64626004e05797a)

Issues and feature requests
---------------------------

Please report your issues and ask for new features on the GitHub Issue Tracker
at https://github.com/mimmi20/BrowserDetector/issues
