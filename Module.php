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
      $LpiAssets = $e->getApplication()->getServiceManager()->get('LpiAssetLoader\Model\AssetLoader');
      $LpiAssets->setRouteMatch($route_name);
      $ViewModel->setVariable('LpiAssets', $LpiAssets);
   }
}
