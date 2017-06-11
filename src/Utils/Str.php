<?php

namespace iamsalnikov\ConfigBuilder\Utils;

class Str
{
    protected static $capitalizeSeparatePattern = '/([^\p{Lu}{delimiter}])([\p{Lu}])/';

    /**
     * Insert before Capital letters delimiter
     *
     * Delimiter will be inserted before each capital letter, except letters in
     * start of string and letters after capital letters
     *
     * For example
     *
     * insertBeforeCapitalLetters('_', 'HelloWorldEMail') -> 'Hello_World_EMail'
     *
     * @param $delimiter
     * @param $string
     * @return string
     */
    public static function insertBeforeCapitalLetters($delimiter, $string)
    {
        $pattern = str_replace('{delimiter}', $delimiter, static::$capitalizeSeparatePattern);
        return (string) preg_replace($pattern, '$1' . $delimiter . '$2', $string);
    }
}