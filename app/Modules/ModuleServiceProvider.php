<?php 

namespace App\Modules;

/**
* 
*/
class ModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function boot(){
		$modules = config("module.modules");

		foreach($modules as $module) {

			// Load the routes for each of the modules
            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }

            // Load the views
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
		}
	}

	public function register(){}
}