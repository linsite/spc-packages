<?php

namespace staticphp\package;

use staticphp\package;
use staticphp\step\CreatePackages;

class fpm implements package
{
    public function getFpmConfig(): array
    {
        $contents = file_get_contents(INI_PATH . '/php-fpm.conf');
        $contents = str_replace('$confdir', getConfdir(), $contents);
        file_put_contents(TEMP_DIR . '/php-fpm.conf', $contents);
        return [
            'depends' => [
                CreatePackages::getPrefix() . '-cli',
            ],
            'files' => [
                TEMP_DIR . '/php-fpm.conf' => getConfdir() . '/php-fpm.conf',
                INI_PATH . '/www.conf' => getConfdir() . '/fpm.d/www.conf',
                INI_PATH . '/php-fpm.service' => '/usr/lib/systemd/system/php-zts-fpm.service',
                BUILD_BIN_PATH . '/php-fpm' => '/usr/sbin/php-zts-fpm',
            ],
            'empty_directories' => [
                getConfdir() . '/fpm.d/',
                '/var/log/php-zts/php-fpm',
            ],
            'directories' => [
                getConfdir() . '/fpm.d/',
                '/var/log/php-zts/php-fpm',
            ],
        ];
    }

    public function getFpmExtraArgs(): array
    {
        return [];
    }
}
