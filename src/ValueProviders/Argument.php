<?php

namespace iamsalnikov\ConfigBuilder\ValueProviders;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;
use iamsalnikov\ConfigBuilder\Values\Nil;
use iamsalnikov\ConfigBuilder\Utils\Str;

/**
 * Class Argument
 * @package iamsalnikov\ConfigBuilder\ValueProviders
 *
 * DO NOT USE IT YET
 */
class Argument implements ValueProvider
{
    /**
     * @inheritDoc
     */
    public function getValue($param)
    {
        $param = $this->getParamName($param);
        $value = getopt('', [$param . '::']);

        return array_key_exists($param, $value) ? $value[$param] : new Nil();
    }

    /**
     * Get param name
     *
     * @param $param
     * @return mixed
     */
    protected function getParamName($param)
    {
        $param = strtolower(Str::insertBeforeCapitalLetters('-', $param));
        return preg_replace('/([\.])([^-])/', '-$2', $param);
    }
}
