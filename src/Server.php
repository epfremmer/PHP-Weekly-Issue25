<?php
/**
 * File Server.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly;

use React\EventLoop\LoopInterface;
use React\Socket\Server as SocketServer;
use React\Stream\ReadableStreamInterface;
use React\Stream\WritableStreamInterface;

/**
 * Class Server
 *
 * @package PHPWeekly
 */
class Server extends SocketServer
{
    const DEFAULT_HOST = '127.0.0.1';

    /**
     * @var WritableStreamInterface
     */
    private $logger;

    /**
     * @var WritableStreamInterface
     */
    private $stream;

    /**
     * Constructor
     *
     * @param LoopInterface $loop
     * @param WritableStreamInterface $stream
     * @param WritableStreamInterface $logger
     */
    public function __construct(
        LoopInterface $loop,
        WritableStreamInterface $stream,
        WritableStreamInterface $logger = null
    ) {
        parent::__construct($loop);

        $this->stream = $stream;
        $this->logger = $logger;
    }

    /**
     * Create simple server listener configured to return
     * encrypted connection data
     *
     * @param int $port
     * @param string $host
     * @throws \React\Socket\ConnectionException
     */
    public function listen($port, $host = self::DEFAULT_HOST)
    {
        parent::listen($port, $host);

        $this->on('connection', function ($conn) {
            /** @var WritableStreamInterface|ReadableStreamInterface $conn */
            $conn->write("Hello there!\n");
            $conn->write("Welcome to this amazing server!\n");
            $conn->write("Send data to be encoded.\n");

            // must be bound before pipe(s) to skip piping command
            $conn->on('data', function($data) use ($conn) {
                if (trim($data) === "quit") {
                    $conn->close();
                }
            });

            if ($this->logger) {
                $conn->pipe($this->logger);
            }

            $conn->pipe($this->stream)->pipe($conn);
        });
    }
}
