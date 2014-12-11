<?php
/**
 * Enhanced Shell Scripts
 * 
 * @category   Steverobbins
 * @package    Steverobbins_Shell
 * @author     Steve Robbins <steven.j.robbins@gmail.com>
 * @copyright  Copyright (c) 2014 Steve Robbins (https://github.com/steverobbins)
 * @license    http://creativecommons.org/licenses/by/3.0/deed.en_US Creative Commons Attribution 3.0 Unported License
 */

require_once 'abstract.php';

class Local_Shell_SampleScript extends Local_Shell_Abstract
{
    /**
     * Enable for debug output
     * @var boolean
     */
    protected $_debug = true;

    /**
     * File to log output to, leave blank for no logging
     */
    protected $_logFile = 'localShellSampleScript.log';

    /**
     * Do the thing
     * 
     * @return void
     */
    public function run()
    {
        $this->debug('Script execution has started');
        $products = $this->getFakeProductCollection();
        $count = count($products);
        $this->debug('Found ' . $count . ' product(s) to process');
        $i = 0;
        foreach ($products as $product) {
            $this->progress(
                'Processing product id: ' . $product->getId(),
                ++$i,
                $count,
                1
            );
            // $product->setDescription(Mage::helper('core')->stripTags($product->getDescription()));
            $this->debug('Sanitizing product description...', 2);
            if (mt_rand(0, 19) > 1) { // try
                // $product->save();
                $this->success('Product saved', 2);
            } else { // catch                
                $this->error('An error occured while saving this product', 2);
            }
        }
        $this->debug('Script execution is complete');
    }

    /**
     * Pretend we're getting some products
     * 
     * @return array
     */
    public function getFakeProductCollection()
    {
        $products = array();
        for ($i = 1; $i < 21; $i++) {
            $products[] = new Varien_Object(array(
                'id'  => $i
            ));
        }
        return $products;
    }
}

$shell = new Guidance_Shell_SampleScript();
$shell->run();
