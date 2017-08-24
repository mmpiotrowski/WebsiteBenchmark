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

use WebsiteBenchmark\Ranking;
use WebsiteBenchmark\Timer;

/**
 * Benchmark class is tool that measure test time for other classes implements competitor interface
 * @version 0.1
 * 
 * @author Michal Piotrowski
 */
class Benchmark {

    /**
     * Must be an object with an implemented Competitor interface
     * @var Object  
     */
    protected $_subject;

    /**
     * array of competitors objects
     * @var array of competitors objects 
     */
    protected $_competitors = [];

    /**
     *
     * @var Ranking object
     */
    protected $_ranking;

    /**
     * Name of benchmarking classes
     * @var string
     */
    protected $_benchmarkingClass;

    /**
     *
     * @var Configure object
     */
    protected $_config;

    /**
     * Array contains callbacks objects
     * 
     * @var array
     */
    protected $_callbacksRegister = [];

    /**
     * Array contains callbacks status
     * 
     * @var array
     */
    protected $_callbacksStatus = [];

    /**
     * Default time format show in results
     * @var string
     */
    protected $_timeFormat = '[d-m-Y  H:i:s]';

    /**
     * 
     * @param \WebsiteBenchmark\Configure $config
     * @param string $subjectOptions
     * @param string $competitorsOptions
     */
    function __construct(Configure $config, $subjectOptions, $competitorsOptions = null) {
        $this->_config = $config;
        $this->_callbacksRegister = $this->_initCallbacks($config->get('benchmark', 'callbacks'));
        $this->_ranking = new Ranking();
        $this->setTimeFormat($this->_config->get('benchmark', 'time_format'));

        $this->_benchmarkingClass = __NAMESPACE__ . '\\' . $config->get('benchmark', 'benchmarking_class');

        if (is_array($subjectOptions)) {
            $args = $this->_fetchArgs($subjectOptions, $competitorsOptions);
            $subjectOptions = $args['subjectOptions'];
            $competitorsOptions = $args['competitorsOptions'];
        }


        $this->_subject = new $this->_benchmarkingClass($subjectOptions);
        $this->_subject->setAsSubject();
        $this->_competitors = $this->_fetchCompetitors($competitorsOptions);
    }

    /**
     * Mesure execution time of test function in competitor object
     * after test fire callbacks function afterTest
     * 
     * @param type $competitor
     * @return object 
     */
    protected function _testCompetitor($competitor) {

        $timer = new Timer;

        $timer->start();
        $testResults = $competitor->test();
        $timer->stop();
        if ($testResults === false) {
            $competitor->setTestTime($testResults);
        } else {
            $competitor->setTestTime($timer->getLastElapsedTime());
        }
        $this->_dispatchCallbacks('afterTest', $competitor);
        return $competitor;
    }

    /**
     * Run test for all competitors objects and subject,
     * makes ranking object and fire callbacks funtion afterRun
     * 
     * @return boolean - return true if done
     */
    public function run() {
        $this->_ranking->setSubject($this->_testCompetitor($this->_subject));
        foreach ($this->_competitors as $competitor) {
            $this->_ranking->addToRanking($this->_testCompetitor($competitor));
        }
        $this->_ranking->setTestDate(date($this->_timeFormat));
        $this->_ranking->makeRanking();
        $this->_dispatchCallbacks('afterRun', $this->_ranking);
        return true;
    }

    /**
     * Returns config object
     * 
     * @return \Website\Configure
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * Sets benchamrk time format
     * 
     * @param string $format
     */
    public function setTimeFormat($format) {
        $this->_timeFormat = $format;
    }

    /**
     * Returns time format
     * 
     * @return string time format
     */
    public function getTimeFormat() {
        return $this->_timeFormat;
    }

    /**
     * Check callback status
     * 
     * @param string $name - callback class and function name in format Class.functionName
     * @return boolean - if callabck pass returns true otherwise false
     */
    public function getCallbackStatus($name) {
        $tmpName = explode('.', $name);
        $callbackClassName = __NAMESPACE__ . '\\Callbacks\\' . $tmpName[0] . 'Callbacks';

        $functionName = $tmpName[1];
        if (isset($this->_callbacksStatus[$callbackClassName][$functionName])) {
            return $this->_callbacksStatus[$callbackClassName][$functionName];
        }
        return false;
    }

    /**
     * Dispatching callbacks funtions
     * 
     * @param string $functionName
     * @param mixed $params
     */
    protected function _dispatchCallbacks($functionName, $params) {
        foreach ($this->_callbacksRegister as $callbackObject) {
            if (method_exists($callbackObject, $functionName)) {
                $this->_callbacksStatus[get_class($callbackObject)][$functionName] = $callbackObject->{$functionName}($params);
            }
        }
    }

    /**
     * Initialize callbacks objects
     * 
     * @param type $callbacksClassesNames
     * @return \WebsiteBenchmark\tmpClassName
     */
    protected function _initCallbacks($callbacksClassesNames) {

        $tmp = [];
        if (!empty($callbacksClassesNames)) {
            $callbacksClassesNames = explode(';', $callbacksClassesNames);
            foreach ($callbacksClassesNames as $tmpClassName) {
                $tmpClassName = __NAMESPACE__ . '\\Callbacks\\' . $tmpClassName . 'Callbacks';
                if (class_exists($tmpClassName)) {
                    $tmp[] = new $tmpClassName($this);
                }
            }
        }
        return $tmp;
    }

    /**
     * Fetch arguments passed by console
     * 
     * @param array $argv - array with arguments
     * @param int $argc - arguments count
     * @return array - return array with subjectOptions and competitorsOptions
     */
    protected function _fetchArgs($argv, $argc) {
        if ($argc < 3) {
            echo 'At least two arguments expected. See readme.txt';
            exit;
        }

        $tmpOptions = [
            'subjectOptions' => null,
            'competitorsOptions' => null
        ];


        $tmpOptions['subjectOptions'] = $argv[1];
        unset($argv[0]); // delete php file from agrv
        unset($argv[1]); // delete subjectOptions from agrv

        if ($argc === 3) {
            $argv = array_pop($argv);
        }

        $tmpOptions['competitorsOptions'] = $argv;

        return $tmpOptions;
    }

    /**
     * Fetch competitors options and creates competitors objects
     * 
     * @param string|array $competitors - competitors options in string or array
     * @return array - return array of competitors objects
     */
    protected function _fetchCompetitors($competitors) {
        $tmp = [];
        if (!is_array($competitors)) {
            $tmpCompetitors = explode(',', $competitors);
        } else {
            $tmpCompetitors = $competitors;
        }

        foreach ($tmpCompetitors as $tmpCompetitor) {
            $tmp [] = new $this->_benchmarkingClass($tmpCompetitor);
        }
        return $tmp;
    }

}
