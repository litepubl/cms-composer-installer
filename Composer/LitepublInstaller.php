<?php
namespace litepubl\Composer;

use Composer\Installers\BaseInstaller;

class LitepublInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'plugins/{$name}/',
        'theme'     => 'themes/{$name}/',
        'shop'     => 'shop/{$name}/',
    );
}
