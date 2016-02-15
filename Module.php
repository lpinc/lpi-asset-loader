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
      $eventManager->attach('dispatch', array($this, 'setLpiAssetLoaderHelper'), 15);
   }

   public function setLpiAssetLoaderHelper(MvcEvent $e) {

      $route_name = $e->getRouteMatch()->getMatchedRouteName();
      $ViewModel = $e->getViewModel();
      $LpiAssetLoader = $e->getApplication()->getServiceManager()->get('LpiAssetLoader\Model\AssetLoader');
      $LpiAssetLoader->setRouteMatch($route_name);

      /**
       * TODO: delete/depricate legacy layout object varibale name at version 1.0
       * Keep for now for back compatibility
       */
      $ViewModel->setVariable('LpiAssets', $LpiAssetLoader);
      $ViewModel->setVariable('LpiAssetLoader', $LpiAssetLoader);
   }
}
