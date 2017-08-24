<?php

/*
 * The MIT License
 *
 * Copyright 2017 Michal Piotrowski.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace WebsiteBenchmark;

use WebsiteBenchmark\BenchmarkException\FileAccessException;

/**
 * Log class it allows to create and writes the log file
 * @version 0.1
 * 
 * 
 * 
 * @author Michal Piotrowski
 */
class Log {

    /**
     * Holds file handle
     * @var resource
     */
    protected $_fileHandle;

    /**
     * Default mode to file open
     * @var string
     */
    protected $_deafultMode = 'a+';

    /**
     * Default time format show in the log
     * @var string
     */
    protected $_timeFormat = '[d-m-Y  H:i:s]';

    /**
     * Opens file handle
     * 
     * @param string $filename
     */
    public function __construct($filename) {
     
        $this->_fileHandle = fopen($filename, $this->_deafultMode);

        if ($this->_fileHandle === false)
            throw new FileAccessException(null, 0, null, $filename);
    }

    /**
     * Close file handle
     * 
     */
    public function __destruct() {
        fclose($this->_fileHandle);
    }

    /**
     * Write message to log file with or without timestamp
     * 
     * @param string $message - message write in to log
     * @param bool $appendDate - with timestape or not
     */
    public function writeToLog($message, $appendDate = true) {
        $date = '';
        if ($appendDate)
            $date = $this->_getTime().' ';

        $message = $date . $message;
        flock($this->_fileHandle, LOCK_EX);
        $results = @fwrite($this->_fileHandle, $message);
        flock($this->_fileHandle, LOCK_UN);
        
        return $results;
    }

    /**
     * Returns the current timestamp
     *  
     * @return string with the current date
     */
    protected function _getTime() {
        return date($this->_timeFormat);
    }

}
