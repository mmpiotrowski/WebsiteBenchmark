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
use WebsiteBenchmark\Email;
/**
 * EmailCallbacks class - benchmark callbacks 
 * send email with results after benchmark tests
 *
 * @author Michal Piotrowski
 */
class EmailCallbacks extends BenchmarkCallbacks {
   
    protected $_email;
   
    /**
     * Create Email object
     *     
     * @param \WebsiteBenchmark\Configure $config - need config to read email settings
     */
    public function __construct($benchmark) {
       parent::__construct($benchmark);
       
       $host = $this->_config->get('email', 'host');
       $port = $this->_config->get('email', 'port');
       $encryption = $this->_config->get('email', 'encryption');
       $username = $this->_config->get('email', 'username');
       $password = $this->_config->get('email', 'password');       
       $this->_email = new Email($host,$port,$encryption,$username,$password);
    }
    
    /**
     * 
     * 
     * @param \WebsiteBenchmark\Ranking $ranking - ranking object contain benchmark results
     */
    public function afterRun($ranking) {
      $from = $this->_config->get('email', 'from');   
      $to = $this->_config->get('email', 'to'); 
      $subject = 'Resutls for Website Benchmark';
      $body =  '';
      $rankingList = $ranking->getRanking();
        foreach ($rankingList as $p => $competitor) {
            $position = $p +1;
            if ($competitor->isSubject()) {
                $body .= $position.'. <span style="font-weight: bold; text-color:red;"> Results for ' . $competitor->getName() . ' time: ' . $competitor->getTestTime() .' ms </span>  <b> - this is benchmark subject </b>'. '<br>';
            } else {
                $diffTime = $competitor->getDiffTime();
                $after = 'slower';
                if($diffTime < 0) $after = 'faster';
                $body .= $position.'. Results for ' . $competitor->getName() . ' time: ' . $competitor->getTestTime() . ' ms ' . $diffTime.' ms '.$after . ' than the subject. <br>';
            }
        }
        
        return $this->_email->send($from,$to,$subject,$body,'',TRUE);
        
    }
}
