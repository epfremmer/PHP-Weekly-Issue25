<?php
/**
 * File index.php
 *
 * @package PHP_Weekly
 */

require_once 'vendor/autoload.php';

use PHPWeekly\Stream\DecryptStream;
use PHPWeekly\Stream\EncryptStream;
use PHPWeekly\Stream\LoggerStream;
use PHPWeekly\Stream\QuitterStream;
use React\EventLoop;
use React\Stream\Stream;

const KEY = 'GLADOS';

$loop = EventLoop\Factory::create();

// create stdin/stdout streams
$in = new Stream(fopen('php://stdin', 'r'), $loop);
$out = new Stream(fopen('php://stdout', 'w'), $loop);

// create encryption streams
$encryptor = new EncryptStream(KEY);
$decryptor = new DecryptStream(KEY);

// shutdown on "exit" command input
$quitter = new QuitterStream($loop);

// logs piped input to stdout
$logger = new LoggerStream(LoggerStream::DEBUG);

$in->pipe($logger);
$in->pipe($quitter);

$encryptor->pipe($logger);
$decryptor->pipe($logger);

$logger->pipe($out);

$in->pipe($encryptor)
    ->pipe($decryptor)
    ->pipe($out);

$loop->run();
