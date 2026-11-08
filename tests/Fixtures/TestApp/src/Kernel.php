<?php

namespace TestApp;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return __DIR__ . '/../../../../build/cache/' . $this->getEnvironment();
    }

    public function getLogDir(): string
    {
        return __DIR__ . '/../../../../build/kernel_logs/' . $this->getEnvironment();
    }

//    /**
//     * @return list<string> An array of allowed values for APP_ENV
//     */
//    private function getAllowedEnvs(): array
//    {
//        return ['prod', 'dev', 'test'];
//    }


}
