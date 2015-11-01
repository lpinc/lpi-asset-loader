<?php

namespace LpiAssetLoader;

use LpiAssetLoader\Model\AssetLoader;
use LpiAssetLoader\Model\AssetLoaderFactory;

return[
   'service_manager' => [
       'factories' => [
           'LpiAssetLoader\Model\AssetLoader' => 'LpiAssetLoader\Model\AssetLoaderFactory'
       ]
   ]
];
