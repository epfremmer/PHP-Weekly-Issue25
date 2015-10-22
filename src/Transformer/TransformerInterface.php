<?php
/**
 * File TransformerInterface.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Transformer;

/**
 * Interface TransformerInterface
 *
 * @package PHPWeekly\Transformer
 */
interface TransformerInterface
{
    /**
     * Returns transformed data
     *
     * @param mixed $data
     * @return mixed
     */
    public function transform($data);
}
