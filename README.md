Magento Shell
===

Add some style to your Magento scripts.

[![Master Build Status](https://img.shields.io/travis/steverobbins/Magento-Shell/master.svg?style=flat-square)](https://travis-ci.org/steverobbins/Magento-Shell)
[![Master Code Quality](https://img.shields.io/scrutinizer/g/steverobbins/Magento-Shell/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/steverobbins/Magento-Shell/?branch=master)

![Sample](http://i.imgur.com/dOpMopl.gif)

# Usage

Extend the `shell/local/abstract.php` class and put your logic in the `run()` method, like you normally would with a Magento shell script.

## Output

Instead of `echo`ing, use the `$this->log` object.  You can output messages using one of `Zend_Log`'s levels

```
<?php

class Zend_Log
{
    const EMERG   = 0;  // Emergency: system is unusable
    const ALERT   = 1;  // Alert: action must be taken immediately
    const CRIT    = 2;  // Critical: critical conditions
    const ERR     = 3;  // Error: error conditions
    const WARN    = 4;  // Warning: warning conditions
    const NOTICE  = 5;  // Notice: normal but significant condition
    const INFO    = 6;  // Informational: informational messages
    const DEBUG   = 7;  // Debug: debug messages
}
```

Example:

```
<?php

require_once 'abstract.php';

class Local_Shell_MyScript extends Local_Shell_Abstract
{
    public function run()
    {
        $this->log->debug('Hello World!');
    }
}
```

## Progress Bar

Create a progress bar with `$bar = $this->progressBar($count);`, where `$count` is an integer of how many items you will iterate over.  `$bar->update($i);` as you walk through, then `$bar->finish();` when complete.

Example:

```
<?php

require_once 'abstract.php';

class Local_Shell_MyScript extends Local_Shell_Abstract
{
    public function run()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $count      = $collection->count();
        $bar        = $this->progressBar($count);
        $i          = 0;
        foreach ($collection as $product) {
            $product->setDescription(strip_tags($product->getDescription()))
                ->save();
            $bar->update(++$i);
        }
        $bar->finish();
    }
}
```

# Support

Please [create an issue](https://github.com/steverobbins/Magento-Shell/issues/new) for all bugs and feature requests

# Contributing

Fork this repository and send a pull request to the `dev` branch

# License

[Creative Commons Attribution 4.0 International](https://creativecommons.org/licenses/by/4.0/)