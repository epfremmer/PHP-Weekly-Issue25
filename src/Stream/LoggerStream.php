<?php
/**
 * File LoggerStream.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Stream;

use React\Stream\ThroughStream;
use React\Stream\WritableStreamInterface;

/**
 * Class LoggerStream
 *
 * @package PHPWeekly\Stream
 */
class LoggerStream extends ThroughStream
{
    const NONE = 'none';
    const DEBUG = 'debug';

    /**
     * @var string
     */
    private $level;

    /**
     * Constructor
     *
     * @param string $level
     */
    public function __construct($level = self::NONE)
    {
        parent::__construct();

        $this->level = $level;

        if ($level === self::DEBUG) {
            $this->bindListener();
        }
    }

    /**
     * Bind event listener during pipe event to set stream
     * source context used while logging data
     *
     * @note This should only be bound in debug mode
     *
     * @return void
     */
    private function bindListener()
    {
        $this->on('pipe', function(WritableStreamInterface $stream) {
            $stream->on('data', function() use ($stream) {
                $this->pipeSource = $stream;
            });
        });
    }

    /**
     * Write only debug data passed to stream
     *
     * @param string $data
     */
    public function write($data)
    {
        if ($this->level === self::DEBUG) {
            parent::write($data);
        }
    }

    /**
     * Timestamp log data
     *
     * @param string $data
     * @return string
     */
    public function filter($data)
    {
        return sprintf('[%s] LOG: Received "%s" from "%s"'. PHP_EOL,
            date('Y-m-d H:i:s'),
            trim($data),
            get_class($this->pipeSource)
        );
    }
}
