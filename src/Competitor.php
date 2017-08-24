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

/**
 * Competitor interface - need to be implemented for benchmarked objects
 * @version 0.1
 * 
 * @author Michal Piotrowski
 */
interface Competitor {

    /**
     * Test function for benchmark
     * 
     * @return boolean - returns false if test failed
     */
    public function test();

    /**
     * Returns name of the benchmarked object
     * 
     * @return string
     */
    public function getName();

   /**
     * Set object as the subject of benchmark
     * 
     */
    public function setAsSubject();

   /**
     * Check the object is the subject of benchmark
     * 
     * @return boolean
     */
    public function isSubject();

    /**
     * Sets test time
     * 
     * @param float $time
     */
    public function setTestTime($time);

    /**
     * Returns test time in miliseconds
     * 
     * @return float
     */
    public function getTestTime();

    /**
     * Sets time differences in relation to the benchmark subject
     * 
     * @param flaot $time
     */
    public function setDiffTime($time);

    /**
     * Returns time differences in relation to the benchmark subject
     * 
     * @return type
     */
    public function getDiffTime();

    /**
     * Returns failures text information
     * 
     * @return string
     */
    public function getFailureInfo();
}
