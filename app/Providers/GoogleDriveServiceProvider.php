<?php
 
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use Google_Client;
use Google_Service_Drive;
use League\Flysystem\Filesystem;
use Storage;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
 
class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google_drive', function($app, $config) {
            $client = new Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $service = new Google_Service_Drive($client);
 
            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }
 
            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);
 
            return new Filesystem($adapter);
        });
    }
 
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}