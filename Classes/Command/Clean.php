<?php

/**
 * This file is part of the FluidLaravel package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoT3\FluidLaravel\Command;

use Illuminate\Console\Command;

/**
 * Artisan command to clear the Twig cache.
 */
class Clean extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'fluid:clean';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Clean the Fluid Cache';

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $fluid    = $this->laravel['fluid'];
        $files    = $this->laravel['files'];
        $cacheDir = $fluid->getCache();

        $files->deleteDirectory($cacheDir);

        if ($files->exists($cacheDir)) {
            $this->error('Fluid cache failed to be cleaned');
        } else {
            $this->info('Fluid cache cleaned');
        }
    }
}