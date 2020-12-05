<?php


namespace App\Utils;


class ImageHelper
{
    protected string $host;

    protected string $kernelDir;

    public function __construct(string $host,string $kernelDir)
    {
        $this->host = $host;
        $this->kernelDir = $kernelDir;
    }

    public function getFull(string $path)
    {
        if (strpos($path,$this->host) === 0) {
            return $path;
        }
        return $this->host . $path;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getKernelDir(): string
    {
        return $this->kernelDir;
    }

    /**
     * @param string $kernelDir
     */
    public function setKernelDir(string $kernelDir): void
    {
        $this->kernelDir = $kernelDir;
    }


}