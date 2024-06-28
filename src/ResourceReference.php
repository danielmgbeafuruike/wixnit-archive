<?php

    namespace Wixnit\Archive;

    class ResourceReference
    {
        public function __construct(
            public string $Title = "",
            public string $URI = "",
            public string $Reference = "",
        ){}
    }