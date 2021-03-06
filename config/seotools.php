<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'       => "Bipolar", // set false to total remove
            'description' => 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru.',
            // set false to total remove
            'separator'   => ' - ',
            'keywords'    => [],
            'canonical'   => null, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'            => 'Bipolar', // set false to total remove
            'description'      => 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru.',
            // set false to total remove
            'url'              => null, // Set null for using Url::current(), set false to total remove
            'locale'           => 'en_US',
            'locale:alternate' => ['es_ES'],
            'type'             => 'article',
            'site_name'        => 'Bipolar',
            'images'           => [],
        ],
    ],
    'twitter'   => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
            'description' => 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru.',
            'title'       => 'Bipolar',
        ],
    ],
];
