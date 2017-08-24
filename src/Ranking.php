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


define('FASTEST_COMPETITOR', 0);

/**
 * Description of Ranking
 * @version 0.1
 *  
 * @author Michal Piotrowski
 * 
 */
class Ranking {

    /**
     * Ranking list of competitors objects
     * 
     * @var array of objects
     */
    protected $_ranking = [];
    
    /**
     * Failures list of competitors objects
     * 
     * @var array of objects
     */
    protected $_failures= [];
    
    /**
     * Subject object
     * 
     * @var object
     */
    protected $_subject;
    
    /**
     * Subject ranking positions
     * 
     * @var int 
     */
    protected $_subjectRankingPosition;
    
    /**
     * Subject ratio relative to the slowest competitor
     * 
     * @var float 
     */
    protected $_subjectSlowestRatio;
    
    /**
     * Subject ratio relative to the fastes competitor
     * 
     * @var float 
     */
    protected $_subjectFastestRatio;
    
    /**
     * Test date
     * 
     * @var string 
     */
    protected $_testDate;
    
    /**
     * Sets subjects object
     * 
     * @param object $subject - object thats implements competitors interface
     */
    public function setSubject($subject) {
        $this->_subject = $subject;
        $this->_ranking[] = $subject;
    }

    /**
     * Add object to ranking 
     * 
     * @param object $competitor - object thats implements competitors interface
     */
    public function addToRanking($competitor) {
        if ($competitor->getTestTime() !== false) {
            $this->_ranking[] = $competitor;
        }else{
            $this->_failures[]  = $competitor;
        }
    }

    /**
     * Gets subject ranking position
     * 
     * @return int
     */
    public function getSubjectRankingPosition() {
        return $this->_subjectRankingPosition;
    }

    /**
     * Returns subjects slowest ratio
     * 
     * @return float
     */
    public function getSubjectSlowestRatio() {
        return $this->_subjectSlowestRatio;
    }

    /**
     * Returns subjects fastest ratio
     * 
     * @return float
     */
    public function getSubjectFastestRatio() {
        return $this->_subjectFastestRatio;
    }

    /**
     * Returns ranking array
     * 
     * @return array - returns array of objects
     */
    public function getRanking() {
        return $this->_ranking;
    }
    
    /**
     * Returns failures array 
     * 
     * @return array
     */
    public function getFailures() {
        return $this->_failures;
    }

    /**
     * Returns subject object
     * 
     * @return object
     */
    public function getSubject() {
        return $this->_subject;
    }

    /**
     * Sets date
     * 
     * @param string $date
     */
    public function setTestDate($date) {
        $this->_testDate = $date;
    }

    public function getTestDate() {
        return $this->_testDate;
    }

    /**
     * Make ranking by usort and complete benchmark info
     * 
     */
    public function makeRanking() {


        usort($this->_ranking, [$this, '_sortRanking']);

        foreach ($this->_ranking as $position => $competitor) {
            if ($competitor->isSubject() == true) {
                $this->_subjectRankingPosition = $position + 1;
            } else {

                $competitor->setDiffTime($competitor->getTestTime() - $this->_subject->getTestTime());
            }
        }


        if ($this->_subjectRankingPosition > 1) {
            $this->_subjectFastestRatio = $this->_subject->getTestTime() / $this->_ranking[FASTEST_COMPETITOR]->getTestTime();
        }
        $slowest_competitor = count($this->_ranking) - 1;
        if ($this->_subjectRankingPosition - 1 < $slowest_competitor) {
            $this->_subjectSlowestRatio = $this->_ranking[$slowest_competitor]->getTestTime() / $this->_subject->getTestTime();
        }
    }

    /**
     * usort function to sorts _ranking objects
     * 
     * @param type $a
     * @param type $b
     * @return int
     */
    protected function _sortRanking($a, $b) {
        $timeA = $a->getTestTime();
        $timeB = $b->getTestTime();
        if ($timeA == $timeB) {
            return 0;
        }
        return ($timeA < $timeB) ? -1 : 1;
    }

}
