<?php

namespace LpiAssetLoader;

use Zend\Mvc\MvcEvent;

class Module {

   public function getConfig() {
      return include __DIR__ . '/config/module.config.php';
   }

   // autoload
   public function getAutoloaderConfig()
   {
      return array(
         'Zend\Loader\StandardAutoloader' => array(
            'namespaces' => array(
               __NAMESPACE__ => __DIR__ . '/src'
            )
         )
      );
   }

   public function onBootstrap(MvcEvent $e)
   {
       $eventManager = $e->getApplication()->getEventManager();
       $eventManager->attach('dispatch', array($this, 'setAssetLoaderHelper'), 15);
   }

   public function setAssetLoaderHelper(MvcEvent $e) {

       $route_name = $e->getRouteMatch()->getMatchedRouteName();

       $ViewModel = $e->getViewModel();
       $sl = $e->getApplication()->getServiceManager();
       $LpiAssets = $sl->get('LpiAssetLoader');
       $LpiAssets->setRouteMatch($route_name);

       $ViewModel->setVariable('LpiAssets', $LpiAssets);
   }

   public function getServiceConfig()
   {
      return array(
         'factories' => array(
            'LpiAssetLoader' => function ($sm) {

               $asset_config = null;
               $AssetConfig = new \LpiAssetLoader\Entity\AssetConfigEntity();
               $config = $sm->get('config');
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
         )
      );
   }
}
