# Logger bundle
[![Build Status](https://scrutinizer-ci.com/g/superbrave/logger-bundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/superbrave/logger-bundle/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/superbrave/logger-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/superbrave/logger-bundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/superbrave/logger-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/superbrave/logger-bundle/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Introduction
A Symfony bundle to log messages to logging providers. Such as Sentry.

## Overview

- Provides a logger that can send messages to Sentry with a variety of severity levels.

## Setup

### Installation

Using this package is similar to all Symfony bundles.

#### Step 1.

Open a command console, enter your project directory and execute the
following command to download the latest version of this bundle:

```
$ composer require superbrave/logger-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#### Step 2.

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Superbrave\LoggerBundle\SuperbraveLoggerBundle(),
        );
        // ...
    }
    // ...
}
```

## License

This bundle is under the MIT license. See the complete license [in the bundle](LICENSE)
