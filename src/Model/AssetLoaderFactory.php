<?php

namespace LpiAssetLoader\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AssetLoaderFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $asset_config = null;
        $AssetConfig = new \LpiAssetLoader\Entity\AssetConfigEntity();
        $config = $serviceLocator->get('config');
        if (array_key_exists('lpi-asset-loader',$config)) {
            foreach ($AssetConfig as $prop => $value) {
                if (array_key_exists($prop, $config['lpi-asset-loader'])) {
                    $AssetConfig->$prop = $config['lpi-asset-loader'][$prop];
                }
            }
        }

        $AssetLoader = new \LpiAssetLoader\Model\AssetLoader($AssetConfig, $asset_config);
        return $AssetLoader;
    }
}