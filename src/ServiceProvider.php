<?php
    namespace Genericmilk\Rollout;

    class ServiceProvider extends \Illuminate\Support\ServiceProvider{

        public function boot()
        {
            $this->setupConfig(); // Load config

        }
        public function register()
        {
            // Import controllers
            $this->app->make('Genericmilk\Rollout\Rollout');
            
        }

        protected function setupConfig(){

            $configPath = __DIR__ . '/../config/Rollout.php';
            $this->publishes([$configPath => $this->getConfigPath()], 'config');
    
        }

        protected function getConfigPath()
        {
            return config_path('Rollout.php');
        }

        protected function publishConfig($configPath)
        {
            $this->publishes([$configPath => config_path('Rollout.php')], 'config');
        }


    }