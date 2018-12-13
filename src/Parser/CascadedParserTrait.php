<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

trait CascadedParserTrait
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \ExceptionalJSON\DecodeErrorException
     *
     * @return mixed
     */
    public function __invoke(string $useragent)
    {
        $factories = $this->jsonParser->decode(
            (string) file_get_contents(__DIR__ . self::GENERIC_FILE),
            true
        );
        $mode      = $factories['generic'];

        foreach (array_keys($factories['rules']) as $rule) {
            //var_dump($rule);
            if (preg_match($rule, $useragent)) {
                $mode = $factories['rules'][$rule];
                break;
            }
        }

        $specFactories = $this->jsonParser->decode(
            (string) file_get_contents(__DIR__ . sprintf(self::SPECIFIC_FILE, $mode)),
            true
        );
        $key           = $specFactories['generic'];

        foreach (array_keys($specFactories['rules']) as $rule) {
            if (preg_match($rule, $useragent)) {
                $key = $specFactories['rules'][$rule];
                break;
            }
        }

        return $this->load($key, $useragent);
    }
}
