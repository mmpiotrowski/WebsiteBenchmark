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

define('CONSOLE_BLUE', "\033[34m");
define('CONSOLE_RED', "\033[31m");
define('CONSOLE_GREEN', "\033[32m");
define('CONSOLE_END_COLOR', "\033[0m");

/**
 * Description of ConsoleCallbacks
 *
 * @author Michal
 */
class ConsoleCallbacks extends BenchmarkCallbacks {

    public function afterRun($ranking) {

        echo PHP_EOL;
        echo CONSOLE_BLUE;
        echo 'Benchmark date: ' . $ranking->getTestDate() . PHP_EOL;
        echo 'Benchmark subject: ' . $ranking->getSubject()->getName() . PHP_EOL;
        echo 'Ratio relative to the fastest: ' . $ranking->getSubjectFastestRatio() . PHP_EOL;
        echo 'Ratio relatie to the slowest : ' . $ranking->getSubjectSlowestRatio() . PHP_EOL;
        echo CONSOLE_END_COLOR;
        echo PHP_EOL;



        $rankingList = $ranking->getRanking();

        echo 'Ranking: ' . PHP_EOL;
        foreach ($rankingList as $p => $competitor) {
            $position = $p + 1;
            if ($competitor->isSubject()) {
                echo $position . "." . CONSOLE_RED . " Results for " . $competitor->getName() . ' time: ' . $competitor->getTestTime() . " ms" . CONSOLE_END_COLOR . ' ' . CONSOLE_GREEN . ' - This is benchmark subject ' . CONSOLE_END_COLOR . PHP_EOL;
            } else {
                $diffTime = $competitor->getDiffTime();
                $after = 'slower';
                if ($diffTime < 0)
                    $after = 'faster';
                echo $position . '. Results for ' . $competitor->getName() . ' time: ' . $competitor->getTestTime() . ' ms ' . $diffTime . ' ms ' . $after . ' than the subject' . PHP_EOL;
            }
        }

        $failuresList = $ranking->getFailures();
        if (count($failuresList) > 0) {
            echo PHP_EOL;
            echo 'Failures: ' . PHP_EOL;
            foreach ($failuresList as $p => $competitor) {
                $position = $p + 1;
                echo $position . '. Test failure for ' . $competitor->getName() . ' Reason: ' . $competitor->getFailureInfo() . PHP_EOL;
            }
        }
        
        return true;
    }

}
