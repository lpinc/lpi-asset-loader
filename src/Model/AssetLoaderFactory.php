<?php

namespace LpiAssetLoader\Model;

use LpiAssetLoader\Model\AssetLoader;
use LpiAssetLoader\Entity\AssetConfigEntity;

class AssetLoaderFactory {

   /**
    *
    * @param container
    * @return LpiAssetLoader\Model\AssetLoader
    */
   public function __invoke($container)
   {
      $asset_config = null;
      $AssetConfig = new AssetConfigEntity();
      $config = $container->get('config');
      if (array_key_exists('lpi-asset-loader',$config)) {
         foreach ($AssetConfig as $prop => $value) {
            if (array_key_exists($prop, $config['lpi-asset-loader'])) {
               $AssetConfig->$prop = $config['lpi-asset-loader'][$prop];
            }
         }
      }

      $AssetLoader = new AssetLoader($AssetConfig, $asset_config);
      return $AssetLoader;
   }
}