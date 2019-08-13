<?php

/**
 * A Log controller, used to download the logs
 */
class Beamngain_Logdownload_Adminhtml_Logdownload_LogController extends Mage_Core_Controller_Front_Action {

    /**
     * Read log file
     */
    public function read_file($file, $lines) {
        //global $fsize;
        $handle = fopen($file, "r");
        $linecounter = $lines;
        $pos = -2;
        $beginning = false;
        $text = array();
        while ($linecounter > 0) {
            $t = " ";
            while ($t != "\n") {
                if (fseek($handle, $pos, SEEK_END) == -1) {
                    $beginning = true;
                    break;
                }
                $t = fgetc($handle);
                $pos --;
            }
            $linecounter --;
            if ($beginning) {
                rewind($handle);
            }
            $text[$lines - $linecounter - 1] = fgets($handle);
            if ($beginning)
                break;
        }
        fclose($handle);
        return array_reverse($text);
    }

    /**
     * check log file
     */
    public function checkAction() {

        $fileName = Mage::getStoreConfig('logdownload/general/log_file_name');
        if (strpos($fileName, '..') > -1) {
            echo Mage::helper('logdownload')->__('Please enter log filename only.');
        } else {

            $filePath = Mage::getBaseDir('var') . "/log/" . $fileName;

            if (file_exists($filePath)) {
                if (is_readable($filePath)) {
                    echo Mage::helper('logdownload')->__('success');
                } else {
                    echo Mage::helper('logdownload')->__('file is not readable.');
                }
            } else {

                echo Mage::helper('logdownload')->__('The provided file path is not valid.');
            }
        }
    }

    /**
     * Download log file
     */
    public function downloadAction() {


        $fileName = Mage::getStoreConfig('logdownload/general/log_file_name');
        $filePath = Mage::getBaseDir('var') . "/log/" . $fileName;
        $line_count_bottom = Mage::getStoreConfig('logdownload/general/log_count_bottom');


        $fileSize = filesize($filePath);
        header("Content-type: text/plain");
        header("Cache-Control: private");
        header("Content-Disposition: attachment; filename=" . $fileName);

        if ($line_count_bottom && (!$line_count_bottom == '')) {
            $fsize = round(filesize($filePath) / 1024 / 1024, 2);
            $lines = $this->read_file($filePath, $line_count_bottom);
            $output = '';
            foreach ($lines as $line) {
                $output .= $line;
            }
            echo $output;
        } else {

            // Output file.
            readfile($filePath);
            exit();
        }
    }

}
