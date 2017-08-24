<?php

/*
 * The MIT License
 *
 * Copyright 2017 Michal Piotrowski
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

use Config_Lite;
use WebsiteBenchmark\BenchmarkException\FileNotFoundException;

/**
 * Configure class - allows to use configure ini files,
 * actualy is wrapper for \Pear\Config_Lite class
 * 
 * @version 0.1
 * 
 * @todo consider to write own configure class with static get and set functions
 *
 * @author Michal Piotrowski
 */
class Configure extends Config_Lite {

    /**
     * Open text ini config file
     * 
     *
     * @throws FileNotFoundException - if config file does not exits
     * @param string $filename - "INI Style" Text Config File
     * @param int    $flags    - flags for file_put_contents, eg. FILE_APPEND
     * @param int    $mode     - set scannermode
     */
    public function __construct($filename = null, $flags = null, $mode = 0) {

        if (file_exists($filename) === true)
            parent::__construct($filename, $flags, $mode);
        else
            throw new FileNotFoundException(null, 0, null, $filename);
    }
    

}
