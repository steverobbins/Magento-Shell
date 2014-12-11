[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/steverobbins/Magento-Shell/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/steverobbins/Magento-Shell/?branch=master)

# Magento Shell Scripts

## Features

* Format output of shell scripts
* Shell output is automatically logged to file
* Execution timer

## Installation

Copy the contents of `src/` to your Magento installation.

*Sorry, modman doesn't work*

## Usage 

See `src/shell/local/sampleScript.php` for example usage.

## Example Output

![Sample Script Screen Shot](http://i.imgur.com/tHtgpCD.png)

Output is also logged:

    $ tail var/log/guidanceShell.log 
    2014-09-30T20:20:42+00:00 DEBUG (7):     Processing product id: 18 (18/20 90%)
    2014-09-30T20:20:42+00:00 DEBUG (7):         Sanitizing product description...
    2014-09-30T20:20:42+00:00 DEBUG (7):         Product saved
    2014-09-30T20:20:42+00:00 DEBUG (7):     Processing product id: 19 (19/20 95%)
    2014-09-30T20:20:42+00:00 DEBUG (7):         Sanitizing product description...
    2014-09-30T20:20:42+00:00 DEBUG (7):         Product saved
    2014-09-30T20:20:42+00:00 DEBUG (7):     Processing product id: 20 (20/20 100%)
    2014-09-30T20:20:42+00:00 DEBUG (7):         Sanitizing product description...
    2014-09-30T20:20:42+00:00 DEBUG (7):         Product saved
    2014-09-30T20:20:42+00:00 DEBUG (7): Script execution is complete
