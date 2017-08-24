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
use WebsiteBenchmark\Log;

/**
 * Description of LogCallback
 *
 * @author Michal Piotrowski
 */
class LogCallbacks extends BenchmarkCallbacks {
    //put your code here
    protected $_singleTestLog;
    protected $_benchmarkLog;
    
    public function __construct($benchmark) {
        parent::__construct($benchmark);
        $singleTestLogFileName = $this->_config->get('log', 'single_test_log');
        $benchmarkLogFileName = $this->_config->get('log', 'benchmark_log');
        $this->_singleTestLog = new Log(LOGS.$singleTestLogFileName);
        $this->_benchmarkLog = new Log(LOGS.$benchmarkLogFileName);
    }
    
    public function afterTest($competitor) {
        $this->_singleTestLog->writeToLog('Results for ' . $competitor->getName() . ' time ' . $competitor->getTestTime().'ms'. PHP_EOL);
        return parent::afterTest($competitor);
        
    }
    
    
     public function afterRun($ranking) {
        
        $log = '###################################################'.PHP_EOL;
        $log .= 'Benchmark date: '.$ranking->getTestDate().PHP_EOL;
        $log .= 'Benchmark subject: '.$ranking->getSubject()->getName().PHP_EOL;
        $log .= 'Ratio relative to the fastest: ' . $ranking->getSubjectFastestRatio() . PHP_EOL;
        $log .= 'Ratio relatie to the slowest : ' . $ranking->getSubjectSlowestRatio(). PHP_EOL;

        $log .=  PHP_EOL;
       
        
        
        $rankingList = $ranking->getRanking();
        $log .= 'Ranking: '.PHP_EOL;
        foreach ($rankingList as $p => $competitor) {
            $position = $p +1;
            if ($competitor->isSubject()) {
                $log .= $position.". Results for " . $competitor->getName() . ' time: ' . $competitor->getTestTime() ." ms  - This is benchmark subject ". PHP_EOL;
            } else {
                $diffTime = $competitor->getDiffTime();
                $after = 'slower';
                if($diffTime < 0) $after = 'faster';
                $log .= $position.'. Results for ' . $competitor->getName() . ' time: ' . $competitor->getTestTime() . ' ms ' . $diffTime.' ms '.$after . ' than the subject'.PHP_EOL;
            }
        }
       
        $results = $this->_benchmarkLog->writeToLog($log,FALSE);
        if($results === false)
            return false;
        
        return parent::afterRun($ranking);
        
    }
}
