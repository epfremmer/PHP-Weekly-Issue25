<?php
/**
 * File QuitterStream.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Stream;

use PHPWeekly\Transformer\VigenereDecipherTransformer;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;
use React\Stream\ThroughStream;
use React\Stream\WritableStream;

/**
 * Class QuitterStream
 *
 * @package PHPWeekly\Stream
 */
class QuitterStream extends WritableStream
{
    const EXIT_CMD = 'exit';

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * Constructor
     *
     * @param LoopInterface $loop
     */
    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    /**
     * Listen for exit command and terminate
     * the event loop
     *
     * @param string $data
     * @return void
     */
    public function write($data)
    {
        if (trim($data) === self::EXIT_CMD) {
            $this->loop->stop();
            $this->close();
        }
    }
}
