<?php

require_once 'abstract.php';

class Local_Shell_SampleScript extends Local_Shell_Abstract
{
    /**
     * Do the thing
     *
     * @return void
     */
    public function run()
    {
        $this->log->info('Script execution has started');
        $products = $this->getFakeProductCollection();
        $count = count($products);
        $this->log->debug('Found ' . $count . ' product(s) to process');
        $bar = $this->progressBar($count);
        $i = 0;
        foreach ($products as $product) {
            $bar->update(++$i);
            // $product->setDescription(Mage::helper('core')->stripTags($product->getDescription()));
            if (mt_rand(0, 19) > 1) {
                //try
                // $product->save();
            } else {
                //catch
                $this->log->err('An error occured while saving product ' . $product['id']);
            }
            sleep(1);
        }
        $bar->finish();
        $this->log->info('Complete');
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

$shell = new Local_Shell_SampleScript();
$shell->run();
