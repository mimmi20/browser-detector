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
namespace BrowserDetector\Loader;

use JsonClass\Json;
use UaResult\Company\Company;
use UaResult\Company\CompanyInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class CompanyLoader implements LoaderInterface
{
    /**
     * @var array[]
     */
    private $companies = [];

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @throws \ExceptionalJSON\DecodeErrorException when the decode operation fails
     * @throws \RuntimeException
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * @throws \ExceptionalJSON\DecodeErrorException when the decode operation fails
     * @throws \RuntimeException
     *
     * @return self
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    /**
     * detects if the company is available
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->companies);
    }

    /**
     * Gets the information about the company
     *
     * @param string $key
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Company\CompanyInterface
     */
    public function load(string $key): CompanyInterface
    {
        if (!$this->has($key)) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        $company = $this->companies[$key];

        return new Company(
            $key,
            $company['name'],
            $company['brandname']
        );
    }

    /**
     * @param string $name
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Company\CompanyInterface
     */
    public function loadByName(string $name): CompanyInterface
    {
        foreach ($this->companies as $key => $companyData) {
            if ($name !== $companyData['name']) {
                continue;
            }

            return $this->load($key);
        }

        throw new NotFoundException('the company with name "' . $name . '" was not found');
    }

    /**
     * @param string $name
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Company\CompanyInterface
     */
    public function loadByBrandName(string $name): CompanyInterface
    {
        foreach ($this->companies as $key => $companyData) {
            if ($name !== $companyData['brandname']) {
                continue;
            }

            return $this->load($key);
        }

        throw new NotFoundException('the company with brand name "' . $name . '" was not found');
    }

    /**
     * initializes cache
     *
     * @throws \ExceptionalJSON\DecodeErrorException when the decode operation fails
     * @throws \RuntimeException
     *
     * @return void
     */
    private function init(): void
    {
        $this->companies = [];

        foreach ($this->getCompanies() as $key => $data) {
            $this->companies[$key] = $data;
        }
    }

    /**
     * @throws \ExceptionalJSON\DecodeErrorException when the decode operation fails
     * @throws \RuntimeException
     *
     * @return array[]|\Generator
     */
    private function getCompanies(): \Generator
    {
        static $companies = null;

        if (null === $companies) {
            $jsonParser = new Json();
            $content    = $this->getContents(__DIR__ . '/../../data/companies/companies.json');

            $companies = $jsonParser->decode(
                $content,
                true
            );
        }

        foreach ($companies as $key => $data) {
            yield $key => $data;
        }
    }

    /**
     * Returns the contents of the file.
     *
     * @param string $path
     *
     * @throws \RuntimeException
     *
     * @return string the contents of the file
     */
    private function getContents(string $path)
    {
        set_error_handler(static function ($type, $msg) use (&$error): void {
            $error = $msg;
        });
        $content = file_get_contents($path);
        restore_error_handler();
        if (false === $content) {
            throw new \RuntimeException($error);
        }

        return $content;
    }
}
