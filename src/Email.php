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
use WebsiteBenchmark\BenchmarkException\EmailSendException;
use PHPMailer;
/**
 * Email class - allows to send email by smtp
 * is wrapper class for PHPMailer
 * 
 * $version 0.1
 *
 * @author Michal Piotrowski
 */
class Email {
    
    protected $_mail;

    /**
     * Open smtp connection
     * 
     * @param string $host - SMTP host name or address
     * @param string $port - SMTP port number
     * @param string $encryption - SMTP encryption type TLS or SSL
     * @param string $username - SMTP user name
     * @param string $password - SMTP password
     */
    public function __construct($host,$port,$encryption,$username,$password) {
       
       $this->_mail = new PHPMailer();
       $this->_mail->isSMTP();
       $this->_mail->SMTPAuth = true; 
       $this->_mail->Host = $host;
       $this->_mail->Port = $port;
       $this->_mail->Username = $username;
       $this->_mail->Password = $password;
       $this->_mail->SMTPSecure = $encryption;
    }

    /**
     * Send email by SMTP
     * 
     * @param string $from - from email address
     * @param string $to - to email address
     * @param string $subject - email subject
     * @param string $body - email body
     * @param string $altBody - alt email body
     * @param bool $isHtml - is email body is Html
     * @return boolean - return true if email was sent
     */
    public function send($from,$to,$subject,$body = "",$altBody ="",$isHtml = false) {
     
        $this->_mail->setFrom($from);
        $this->_mail->addAddress($to);    
        $this->_mail->isHTML($isHtml);                                  

        $this->_mail->Subject = $subject;
        $this->_mail->Body = $body;
        $this->_mail->_AltBody = $altBody;
        
        return $this->_mail->send();
        
           
    }

}
