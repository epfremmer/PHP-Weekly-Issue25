<?php
/**
 * File DecryptStream.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Stream;

use PHPWeekly\Transformer\VigenereDecipherTransformer;
use React\Stream\ThroughStream;

/**
 * Class DecryptStream
 *
 * @package PHPWeekly\Stream
 */
class DecryptStream extends ThroughStream
{
    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct($key)
    {
        parent::__construct();

        $this->transformer = new VigenereDecipherTransformer($key);
    }

    /**
     * Decrypt and return data to be written
     *
     * @param string $data
     * @return string
     */
    public function filter($data)
    {
        return $this->transformer->transform($data);
    }
}
