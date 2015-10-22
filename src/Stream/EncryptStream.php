<?php
/**
 * File EncryptStream.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Stream;

use PHPWeekly\Transformer\VigenereCipherTransformer;
use React\Stream\ThroughStream;

/**
 * Class EncryptStream
 *
 * @package PHPWeekly\Stream
 */
class EncryptStream extends ThroughStream
{
    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct($key)
    {
        parent::__construct();

        $this->transformer = new VigenereCipherTransformer($key);
    }

    /**
     * Encrypt and return data to be written
     *
     * @param string $data
     * @return string
     */
    public function filter($data)
    {
        return $this->transformer->transform($data);
    }
}
