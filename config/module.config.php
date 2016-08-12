<?php

namespace LpiAssetLoader;

use LpiAssetLoader\Model\AssetLoader;
use LpiAssetLoader\Model\AssetLoaderFactory;

return array(
   'service_manager' => array(
      'factories' => array(
         'LpiAssetLoader\Model\AssetLoader' => 'LpiAssetLoader\Model\AssetLoaderFactory'
      )
   )
);
