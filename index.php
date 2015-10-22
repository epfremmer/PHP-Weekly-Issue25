<?php
/**
 * File index.php
 *
 * @package PHP_Weekly
 */

require_once 'vendor/autoload.php';

use PHPWeekly\Server;
use PHPWeekly\Stream\DecryptStream;
use PHPWeekly\Stream\EncryptStream;
use PHPWeekly\Stream\LoggerStream;
use PHPWeekly\Stream\QuitterStream;
use React\EventLoop;
use React\Stream\Stream;

const KEY = 'GLADOS';

$loop = EventLoop\Factory::create();

// create stdin/stdout streams
$in = new Stream(STDIN, $loop);
$out = new Stream(STDOUT, $loop);
$err = new Stream(STDERR, $loop);

$accessLog = new Stream(fopen('access.log', 'a'), $loop);
$debugLog = new Stream(fopen('debug.log', 'a'), $loop);
$errorLog = new Stream(fopen('error.log', 'a'), $loop);

// create encryption streams
$encryptor = new EncryptStream(KEY);
$decryptor = new DecryptStream(KEY);

// shutdown on "exit" command input
$quitter = new QuitterStream($loop);

// logs piped input to stdout
$logger = new LoggerStream(LoggerStream::DEBUG);

// simple socket server (because why not)
// access via 'telnet 127.0.0.1 1337'
$socket = new Server($loop, new DecryptStream(KEY), $accessLog);
$socket->listen(1337);

$in->pipe($logger);
$in->pipe($quitter);

$err->pipe($errorLog);

$encryptor->pipe($logger);
$decryptor->pipe($logger);

$logger->pipe($out);
$logger->pipe($debugLog);

$in->pipe($encryptor)
    ->pipe($decryptor)
    ->pipe($out);

$loop->run();
