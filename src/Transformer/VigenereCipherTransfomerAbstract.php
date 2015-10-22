<?php
/**
 * File VigenereCipherTransfomerAbstract.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Transformer;

use PHPWeekly\Char;

/**
 * Class VigenereCipherTransfomerAbstract
 *
 * @package PHPWeekly\Transformer
 */
abstract class VigenereCipherTransfomerAbstract
{
    // encryption key
    const DEFAULT_KEY = 'ABC';

    /**
     * @var string[]
     */
    private $keyChars = [];

    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->keyChars = array_map(function($char) {
            return new Char($char);
        }, str_split($key));
    }

    /**
     * Reset the encryption key pointer
     * for next input
     *
     * @return void
     */
    protected function reset()
    {
        reset($this->keyChars);
    }

    /**
     * Return current encryption character
     *
     * @return Char
     */
    protected function getChar()
    {
        $current = current($this->keyChars);

        if (!next($this->keyChars)) {
            reset($this->keyChars);
        }

        return $current;
    }
}
