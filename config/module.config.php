<?php

namespace LpiAssetLoader;

use LpiAssetLoader\Model\AssetLoader;
use LpiAssetLoader\Model\AssetLoaderFactory;

return[
   'service_manager' => [
       'factories' => [
           AssetLoader::class => AssetLoaderFactory::class
       ],
   ]
];
