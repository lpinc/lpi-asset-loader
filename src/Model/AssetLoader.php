<?php
namespace LpiAssetLoader\Model;

class AssetLoader {

   /**
    * The asset loader config object
    *
    * @var null|AssetConfigEntity
    */
   private $AssetConfig;

   /**
    * a zf2 route matched name if used
    *
    * @var string
    */
   private $matched_route_name;

   public function __construct(
      \LpiAssetLoader\Entity\AssetConfigEntity $AssetConfig
   ) {
      $this->AssetConfig = $AssetConfig;
   }

   /*
    * get the asset config
    * @return AssetConfigEntity
    */
   public function getConfig() {
      return $this->AssetConfig;
   }

   /*
    * set the asset config
    * @param AssetConfigEntity $AssetConfig
    */
   public function setConfig(\LpiAssetLoader\Entity\AssetConfigEntity $AssetConfig
   ) {
      $this->AssetConfig = $AssetConfig;
   }

   /*
    * get the base vendor path
    *
    * @return string
    */
   public function getBaseVendorPath() {
      $base_vendor_path = ($this->AssetConfig->use_source) ? $this->AssetConfig->base_vendor_src_path : $this->AssetConfig->base_vendor_build_path;
      return $base_vendor_path;
   }

   /*
    * get the base vendor path
    *
    * @return string
    */
   public function getBaseAppPath() {
      $base_app_path = ($this->AssetConfig->use_source) ? $this->AssetConfig->base_app_src_path : $this->AssetConfig->base_app_build_path;
      return $base_app_path;
   }

   /*
    * set the route name so we can know if we need to add a build file
    */
   public function setRouteMatch($matched_route_name) {
      $this->matched_route_name = $matched_route_name;
   }

   /*
    * return the dojo paths config javascript config
    * this will change based on the source setting to either source or build location
    */
   private function getDojoConfigPaths() {
      $html = null;
      if ($this->haveModulesToLoad()) {

         $module_paths = array();
         foreach ($this->AssetConfig->amd_vendor_modules as $module => $location) {
            $base_path = ($this->AssetConfig->use_source) ? $this->AssetConfig->base_vendor_src_path : $this->AssetConfig->base_vendor_build_path;
            $path = sprintf('%s%s',$base_path,$location);
            $module_paths[$module] = $path;
         }

         foreach ($this->AssetConfig->amd_app_modules as $module => $location) {
            $base_path = ($this->AssetConfig->use_source) ? $this->AssetConfig->base_app_src_path : $this->AssetConfig->base_app_build_path;
            $path = sprintf('%s%s',$base_path,$location);
            $module_paths[$module] = $path;
         }
      }
      return $module_paths;
   }

   /*
    * return the dojo javascript config
    */
   public function getDojoConfig() {

      if (! $this->AssetConfig->dojo_on) {
         return null;
      }

      $html = '
<script>
//<!--'.PHP_EOL;
      $html .= 'var dojoConfig = ';

      if ($this->haveModulesToLoad()) {
         $this->AssetConfig->dojo_config_settings['paths'] = $this->getDojoConfigPaths();
      }
      $html .= json_encode($this->AssetConfig->dojo_config_settings);
      $html .= PHP_EOL;
      $html .= '
//-->
</script>'.PHP_EOL;

      return $html;
   }

   /*
    * the main method to call from a zf2 layout file to load the dojo init javascript asset files
    */
   public function getDojoInitAssets() {
       if (! $this->AssetConfig->dojo_on) {
           return null;
       }
       // build dojo init file
       $base_dojo_path = ($this->AssetConfig->use_source) ? $this->AssetConfig->base_vendor_src_path : $this->AssetConfig->base_vendor_build_path;
       $html = sprintf('<script type="text/javascript" src="%sdojo/dojo.js"></script>'.PHP_EOL, $base_dojo_path);

       // add any build files here
       $html .= $this->getJsBuildAssets();

       return $html;
   }

   /*
    * add a single layer (build file) to a zf2 layout file (if in non-source mode)
    *
    * @param string|path
    */
   public function addBuildLayer($layer) {
      if (! $this->AssetConfig->dojo_on) {
          return null;
      }
      $html = null;
      if ($this->AssetConfig->use_source == false) {
         $html .= sprintf('<script type="text/javascript" src="%s%s.js"></script>'.PHP_EOL, $this->AssetConfig->base_app_build_path, $layer);
      }
      return $html;
   }

   /*
    * add config layers if in non-source mode
    */
   public function getJsBuildAssets() {
       if (! $this->AssetConfig->dojo_on) {
           return null;
       }
       $html = null;
       if ($this->AssetConfig->use_source == false) {
          if (count($this->AssetConfig->route_match_build_layers)>0) {
             foreach ($this->AssetConfig->route_match_build_layers as $route => $build_file) {
                if ($this->matched_route_name == $route) {
                   $html .= sprintf('<script type="text/javascript" src="%s%s.js"></script>'.PHP_EOL, $this->AssetConfig->base_app_build_path, $build_file);
                }
             }
          }
       }
       return $html;
   }

   private function haveModulesToLoad() {
      $have_modules = false;
      if (count($this->AssetConfig->amd_app_modules) > 0 || count($this->AssetConfig->amd_vendor_modules) > 0) {
         $have_modules = true;
      }
      return $have_modules;
   }

}
