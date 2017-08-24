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

require 'bootstrap.php';

use PHPUnit\Framework\TestCase;

/**
 * Description of BenchmarkTest
 *
 * @author Michal Piotrowski
 */
class BenchmarkTest extends TestCase {
    



   public function testDependencies()
    {
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $this->assertInstanceOf('WebsiteBenchmark\Benchmark', new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http://pclab.pl'));
    }
    /**
     * @depends testDependencies
     */
    public function testBenchmarkRunWithoutCallbacks(){
        
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $config->set('app', 'callbacks','');
        $benchmark = new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http://pclab.pl');
        $this->assertEquals(true,  $benchmark->run());
    }
    /**
     * @depends testBenchmarkRunWithoutCallbacks
     */
    public function testBenchmarkWithLogCallbacks(){
        
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $config->set('app', 'callbacks','Log');
        $benchmark = new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http://pclab.pl');
        $this->assertEquals(true,  $benchmark->run());
        $this->assertEquals(true,  $benchmark->getCallbackStatus('Log.afterTest'));
        $this->assertEquals(true,  $benchmark->getCallbackStatus('Log.afterRun'));
    }
    /**
     * @depends testBenchmarkWithLogCallbacks
     */
    public function testBenchmarkWithEmailCallbacks(){
        
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $config->set('app', 'callbacks','Email');
        $benchmark = new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http,//pclab.pl');
        $this->assertEquals(true,  $benchmark->run());
        $this->assertEquals(true,  $benchmark->getCallbackStatus('Email.afterRun'));
    }
    
    /**
     * @depends testBenchmarkWithEmailCallbacks
     */
    public function testBenchmarkWithConsoleCallbacks(){
        
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $config->set('app', 'callbacks','Console');
        $benchmark = new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http://pclab.pl');
        $this->assertEquals(true,  $benchmark->run());
        $this->assertEquals(true,  $benchmark->getCallbackStatus('Console.afterRun'));
    }
    
    /**
     * @depends testBenchmarkWithConsoleCallbacks
     */
    public function testBenchmarkWithFakeCallbacks(){
        
        $config = new WebsiteBenchmark\Configure(CONFIG . 'config.ini');
        $config->set('app', 'callbacks','Fake');
        $benchmark = new WebsiteBenchmark\Benchmark($config,'http://gazeta.pl', 'http://wp.pl,http://interia.pl,http://pclab.pl');
        $this->assertEquals(true,  $benchmark->run());
        //$this->assertEquals(true,  $benchmark->getCallbackStatus('Console.afterRun'));
    }
}
