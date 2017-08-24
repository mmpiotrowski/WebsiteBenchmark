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

/**
 * Timer class it measures time from start to stop in milliseconds
 * @version 0.1
 *
 * @todo consider use HRTime\StopWatch
 * 
 * @author Michal Piotrowski
 */
class Timer {
   
   /**
    * Start time in miliseconds
    * 
    * @var float 
    */
   protected $_start;
   
   /**
    * Stop time in miliseconds
    * @var float
    */
   protected $_stop;
   
   /**
    * Starts timer
    */
   public function start(){
       $this->_start = microtime(TRUE);
   }
   
   /**
    * Stops timer
    */
   public function stop(){
       $this->_stop = microtime(TRUE);
   }
   
   /**
    * Returns the elapsed time
    * @throws Exception
    * @return float 
    */
   public function getLastElapsedTime(){
       $elapsedTime = $this->_stop - $this->_start;
       
       if($elapsedTime < 0)
           throw new TimerElapsedTimeException();
       
       return $elapsedTime;
   }
   
   

}
