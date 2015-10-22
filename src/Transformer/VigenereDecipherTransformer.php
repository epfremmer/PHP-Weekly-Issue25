<?php
/**
 * File VigenereDecipherTransformer.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Transformer;

use PHPWeekly\Char;

/**
 * Class VigenereDecipherTransformer
 *
 * @package PHPWeekly\Transformer
 */
class VigenereDecipherTransformer extends VigenereCipherTransfomerAbstract implements TransformerInterface
{
    /**
     * Decrypt string via Vingen cypher strategy
     *
     * @see https://en.wikipedia.org/wiki/Vigen%C3%A8re_cipher
     *
     * @param $data
     * @return mixed
     */
    public function transform($data)
    {
        $chars = str_split($data);
        $chars = array_map([$this, 'dencryptChar'], $chars);

        $this->reset();

        return implode('', $chars);
    }

    /**
     * Decrypt single character
     *
     * @param string $char
     * @return string
     */
    private function dencryptChar($char)
    {
        if (!preg_match('/^[a-z]{1}/i', $char)) {
            return $char;
        }

        $char = new Char($char);

        $char->subtract($this->getChar());

        return (string) $char;
    }
}
