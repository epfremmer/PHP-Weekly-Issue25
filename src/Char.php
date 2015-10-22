<?php
/**
 * File Char.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly;

/**
 * Class Char
 *
 * @package PHPWeekly
 */
class Char
{
    const CHAR_COUNT = 26;
    const UPPERCASE_A = 65;
    const UPPERCASE_Z = 90;
    const LOWERCASE_A = 97;
    const LOWERCASE_Z = 122;

    /**
     * @var string
     */
    private $char;

    /**
     * @var int
     */
    private $ord;

    /**
     * Constructor
     *
     * @param string $char
     */
    public function __construct($char)
    {
        $this->char = $char;
        $this->ord = ord($char);
    }

    /**
     * Add character offset
     *
     * @param Char $char
     */
    public function add(Char $char)
    {
        $this->ord += $char->index();

        $upper = $this->isLower() ? self::LOWERCASE_Z : self::UPPERCASE_Z;

        if ($this->ord > $upper) {
            $this->ord -= self::CHAR_COUNT;
        }

        $this->char = chr($this->ord);
    }

    /**
     * Subtract character offset
     *
     * @param Char $char
     */
    public function subtract(Char $char)
    {
        $this->ord -= $char->index();

        $lower = $this->isLower() ? self::LOWERCASE_A : self::UPPERCASE_A;

        if ($this->ord < $lower) {
            $this->ord += self::CHAR_COUNT;
        }

        $this->char = chr($this->ord);
    }

    /**
     * Get character offset value
     *
     * @return int
     */
    public function index()
    {
        $zero = $this->isLower() ? self::LOWERCASE_A : self::UPPERCASE_A;

        return $this->ord - $zero;
    }

    /**
     * Test if current character is lower case
     *
     * @return bool
     */
    private function isLower()
    {
        return ctype_lower($this->char);
    }

    /**
     * Return to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->char;
    }
}
