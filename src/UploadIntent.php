<?php

    namespace Wixnit\Archive;

    class UploadIntent
    {
        public function __construct(
            public string $Token = "",
            public string $FileName = "",
        ){}
    }