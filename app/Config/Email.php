<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'akkr123321@gmail.com';  // From email address
    public string $fromName   = 'Your Name';             // From name (could be your app or your name)
    public string $recipients = '';

    public string $protocol = 'smtp';
    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'akkr123321@gmail.com'; // Your Gmail address
    public string $SMTPPass = 'xgcg ikvp qske utta'; // Generated App Password
    public int $SMTPPort = 587; // Use 587 for TLS
    public string $SMTPCrypto = 'tls';

    public string $mailType = 'html';
    public string $charset  = 'utf-8';
    public string $newline  = "\r\n";

    public int $SMTPTimeout = 5;
    public bool $SMTPKeepAlive = false;
    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public bool $validate = false;
    public int $priority = 3;
    public string $CRLF = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;
    public bool $DSN = false;
}

?>