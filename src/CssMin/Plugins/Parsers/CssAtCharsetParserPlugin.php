<?php

namespace PHPMin\CssMin\Plugins\Parsers;

use PHPMin\CssMin\Tokens\CssAtCharsetToken;

/**
 * {@link CssParserPluginAbstract Parser plugin} for parsing @charset at-rule.
 *
 * If a @charset at-rule was found this plugin will add a {@link CssAtCharsetToken} to the parser.
 *
 * @package     CssMin/Parser/Plugins
 * @author      2018 David Bolye <https://github.com/dbx123>
 * @author      2014 Joe Scylla <joe.scylla@gmail.com>
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @version     1.0.1
 */
class CssAtCharsetParserPlugin extends CssParserPluginAbstract
{
    /**
     * Implements {@link CssParserPluginAbstract::getTriggerChars()}.
     *
     * @return array
     */
    public function getTriggerChars()
    {
        return array("@", ";", "\n");
    }

    /**
     * Implements {@link CssParserPluginAbstract::getTriggerStates()}.
     *
     * @return array
     */
    public function getTriggerStates()
    {
        return array("T_DOCUMENT", "T_AT_CHARSET");
    }

    /**
     * Implements {@link CssParserPluginAbstract::parse()}.
     *
     * @param integer $index Current index
     * @param string $char Current char
     * @param string $previousChar Previous char
     * @return mixed TRUE will break the processing;
     * FALSE continue with the next plugin; integer set a new index and break the processing
     */
    public function parse($index, $char, $previousChar, $state)
    {
        if ($char === "@" && $state === "T_DOCUMENT"
            && strtolower(substr($this->parser->getSource(), $index, 8)) === "@charset"
        ) {
            $this->parser->pushState("T_AT_CHARSET");
            $this->parser->clearBuffer();
            return $index + 8;
        } elseif (($char === ";" || $char === "\n") && $state === "T_AT_CHARSET") {
            $charset = $this->parser->getAndClearBuffer(";");
            $this->parser->popState();
            $this->parser->appendToken(new CssAtCharsetToken($charset));
        } else {
            return false;
        }
        
        return true;
    }
}
