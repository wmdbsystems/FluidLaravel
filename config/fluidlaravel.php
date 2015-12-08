<?php

/**
 * This file is part of the FluidLaravel package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Configuration options for Fluid.
 */
return [

    'fluid' => [
        /*
        |--------------------------------------------------------------------------
        | Extension
        |--------------------------------------------------------------------------
        |
        | File extension for Fluid view files.
        |
        */
        'extension' => 'html',

        /*
        |--------------------------------------------------------------------------
        | Accepts all Fluid environment configuration options
        |--------------------------------------------------------------------------
        |
        */
        'environment' => [],

        /*
        |--------------------------------------------------------------------------
        | Global variables
        |--------------------------------------------------------------------------
        |
        | These will always be passed in and can be accessed as Twig variables.
        | NOTE: these will be overwritten if you pass data into the view with the same key.
        |
        */
        'globals' => [],
    ],
];