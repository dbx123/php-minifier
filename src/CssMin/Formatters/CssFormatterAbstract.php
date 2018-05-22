<?php

namespace PHPMin\CssMin\Formatters;

/**
 * Abstract formatter definition.
 *
 * Every formatter have to extend this class.
 *
 * @package     CssMin/Formatter
 * @author      2018 David Bolye <https://github.com/dbx123>
 * @author      2014 Joe Scylla <joe.scylla@gmail.com>
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @version     1.0.1
 */
abstract class CssFormatterAbstract
{
    /**
     * Indent string.
     *
     * @var string
     */
    protected $indent = "    ";

    /**
     * Declaration padding.
     *
     * @var integer
     */
    protected $padding = 0;

    /**
     * Tokens.
     *
     * @var array
     */
    protected $tokens = array();

    /**
     * Constructor.
     *
     * @param array $tokens Array of CssToken
     * @param string $indent Indent string [optional]
     * @param integer $padding Declaration value padding [optional]
     */
    public function __construct(array $tokens, $indent = null, $padding = null)
    {
        $this->tokens   = $tokens;
        $this->indent   = !is_null($indent) ? $indent : $this->indent;
        $this->padding  = !is_null($padding) ? $padding : $this->padding;
    }

    /**
     * Returns the array of CssTokenAbstract as formatted string.
     *
     * @return string
     */
    abstract public function __toString();
}
