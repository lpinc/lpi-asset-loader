<?php
namespace LpiAssetLoader\Entity;

class AssetConfigEntity {

   /*
    * will we be loading assets from source
    */
   public $use_source = true;

   /*
    *  the source path to app javascript from docroot path
    */
   public $base_app_src_path = 'js/';

   /*
    *  the source path to vendor javascript relative from docroot path
    */
   public $base_vendor_src_path = 'node_modules/';

   /*
    *  the build path to app javascript relative from docroot path
    */
   public $base_app_build_path = '';

   /*
    *  the build path to cendor javascript from docroot path
    */
   public $base_vendor_build_path = '';

   /*
    * a switch to turn dojo off
    */
   public $dojo_on = true;

   /*
    * store the dojo configs
    */
   public $dojo_config_settings = array(
      'baseUrl' => '/',
      'async' => 'true',
      'parseOnLoad' => 'false',
      'isDebug' => 'false'
   );

   /*
    * AMD modules in the vendor "bower" space
    */
   public $amd_vendor_modules = array(
      'dojo' => 'dojo/',
      'dijit' => 'dijit/',
      'dojox' => 'dojox/'
   );

   /*
    * AMD modules in the app "js" space
    */
   public $amd_app_modules = array();

   /*
    * this array is to store css files configs settings, matching a route name to a css file
    * mostly used to load special css files for dojo widgets where needed
    */
   public $route_match_css_files = array();

   /*
    * this array is to store build files "layers" configs settings, matching a route name to a build file
    */
   public $route_match_build_layers = array();
}
