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

namespace WebsiteBenchmark\Callbacks;

/**
 * Dummy parent class for benchmark callbacks
 * 
 * @author Michal Piotrowski
 */
class BenchmarkCallbacks {
 
    protected $_config;
    protected $_benchmark;

    /**
     * 
     * @param \WebsiteBenchmark\Benchmark $benchmark
     */
    public function __construct(\WebsiteBenchmark\Benchmark $benchmark) {
        $this->_benchmark = $benchmark;
        $this->_config = $this->_benchmark->getConfig();
    }

        /**
     * Callback after benchmark each competitor test
     * 
     * @param object implements a competitor interface $competitor
     * @return bool - return true if success or false if fails
     */
    public function afterTest($competitor){
        return true;
    }  
    
    /**
     * Callback after all benchmark tests
     * 
     * @param Ranking $ranking
     * @return bool - return true if success or false if fails
     */
    public function afterRun(\WebsiteBenchmark\Ranking $ranking){
        return true;
    }  
    
}
