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
namespace BrowserDetector\Loader\Helper;

use ExceptionalJSON\DecodeErrorException;
use JsonClass\Json;
use Symfony\Component\Finder\SplFileInfo;

class Rules
{
    /**
     * @var \Symfony\Component\Finder\SplFileInfo
     */
    private $file;

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @var string|null
     */
    private $default;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var Json
     */
    private $json;

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @param \JsonClass\Json                       $json
     */
    public function __construct(SplFileInfo $file, Json $json)
    {
        $this->file = $file;
        $this->json = $json;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @return void
     */
    public function __invoke(): void
    {
        try {
            $fileData = $this->json->decode(
                $this->file->getContents(),
                true
            );
        } catch (DecodeErrorException $e) {
            throw new \RuntimeException('file "' . $this->file->getPathname() . '" contains invalid json', 0, $e);
        }

        if (is_array($fileData['rules'])) {
            $this->rules = $fileData['rules'];
        }

        if (is_string($fileData['generic'])) {
            $this->default = $fileData['generic'];
        }

        $this->initialized = true;
    }
}
