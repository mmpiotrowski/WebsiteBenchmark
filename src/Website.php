<?php

/*
 * The MIT License
 *
 * Copyright 2017 Michal.
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

use WebsiteBenchmark\Competitor;

/**
 * Wesite class - cointains website url and implements Competitor interface for benchmark
 * 
 * @version 0.1
 *
 * @author Michal
 */
class Website implements Competitor {

    /**
     * Contain website url address
     * 
     * @var string
     */
    protected $_url;

    /**
     * Creates website object
     * 
     * @param type $url - website url address
     */
    public function __construct($url) {
        $this->_url = $this->_checkUrl($url);
    }
    /**
     * Returns webiste url string
     * 
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }
    
    /**
     * Check website url contain http://
     * 
     * @param string $url
     * @return string - website url with http://
     */
    protected function _checkUrl($url){
        
        $position = strpos($url,'http://');
        if($position === false){
            $url = 'http://'.$url;
        }
        return $url;
    }

    /**
     * Implements of competitor interface
     * ################################################
     */
    
    /**
     * Contain test time in miliseconds
     * 
     * @var float
     */
    protected $_testTime;
    
    /**
     * Contains time differences in relation to the benchmark subject
     * 
     * @var float 
     */
    protected $_diffTime;
    
    /**
     * Contains information about a failed test
     * 
     * @var string
     */
    protected $_failureInfo;
    
    /**
     * Is the object a subject
     * 
     * @var boolean 
     */
    private $_isSubject = false;

    /**
     * Test function for benchmark
     * 
     * @return boolean - returns false if test failed
     */
    function test() {

        $opts = array(
            'http' => array(
                'method' => "GET",
                
            )
        );

        $context = stream_context_create($opts);


        $contents = @file_get_contents($this->_url,false,$context);
        if ($contents === false) {
            $this->_failureInfo = 'Page ' . $this->_url . ' can not be found';
            return false;
        }

        return true;
    }

    /**
     * Returns name of the benchmarked object
     * 
     * @return string
     */
    function getName() {
        return $this->getUrl();
    }

    /**
     * Set object as the subject of benchmark
     * 
     */
    function setAsSubject() {
        $this->_isSubject = true;
    }

    /**
     * Check the object is the subject of benchmark
     * 
     * @return boolean
     */
    function isSubject() {
        return $this->_isSubject;
    }

    /**
     * Sets test time
     * 
     * @param float $time
     */
    function setTestTime($time) {
        $this->_loadTime = $time;
    }

    /**
     * Returns test time in miliseconds
     * 
     * @return float
     */
    function getTestTime() {
        return $this->_loadTime;
    }

    /**
     * Sets time differences in relation to the benchmark subject
     * 
     * @param flaot $time
     */
    function setDiffTime($time) {
       $this->_diffTime = $time;
    }

    /**
     * Returns time differences in relation to the benchmark subject
     * 
     * @return type
     */
    function getDiffTime() {
        return $this->_diffTime;
    }

    /**
     * Returns failures text information
     * 
     * @return string
     */
    function getFailureInfo() {
        return $this->_failureInfo;
    }

}
