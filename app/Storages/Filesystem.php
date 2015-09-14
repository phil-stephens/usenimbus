<?php namespace Nimbus\Storages;

use Aws\S3\S3Client;
use Dropbox\Client;
use Barracuda\Copy\API;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\AwsS3v2\AwsS3Adapter;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Copy\CopyAdapter;

class Filesystem {

    public function init($settings)
    {
        if( ! is_object($settings))
        {
            $settings = json_decode($settings);
        }

        $method = 'init' . ucfirst( $settings->driver );

        try
        {
            return $this->$method($settings);
        } catch( \Exception $e)
        {

        }

        return false;
    }

    private function initLocal($settings)
    {
        $path = storage_path().'/app/' . $settings->path;
        return new Flysystem( new Local( $path ));
    }

    private function initS3($settings)
    {
        $client = S3Client::factory([
            'key'       => $settings->key,
            'secret'    => $settings->secret,
            'region'    => $settings->region
        ]);

        return new Flysystem(new AwsS3Adapter($client, $settings->bucket));
    }

    private function initDropbox($settings)
    {
        $client = new Client($settings->token, $settings->appName);

        return new Flysystem(new DropboxAdapter($client) );
    }

    private function initCopy($settings)
    {
        $client = new API(
            $settings->consumerKey,
            $settings->consumerSecret,
            $settings->accessToken,
            $settings->tokenSecret
        );

        return new Flysystem(new CopyAdapter($client));
    }

    public function store($driver, $data)
    {
        $method = 'store' . ucfirst( $driver );

        try
        {
            return $this->$method($data);
        } catch( \Exception $e)
        {

        }

        return false;
    }

    private function storeLocal($data)
    {
        $settings = [
            'driver'    => 'local',
            'path'      => $data['path']
        ];

        return json_encode($settings);
    }

    private function storeS3($data)
    {
        $settings = [
            'driver'    => 's3',
            'key'       => $data['key'],
            'secret'    => $data['secret'],
            'region'    => $data['region'],
            'bucket'    => $data['bucket']
        ];

        return json_encode($settings);
    }

    private function storeDropbox($data)
    {
        $settings = [
            'driver'    => 'dropbox',
            'token'     => $data->accessToken,
            'appName'   => config('services.dropbox.appName')
        ];

        return json_encode($settings);
    }

    private function storeCopy($data)
    {
        $settings = [
            'driver'            => 'copy',
            'consumerKey'       => config('services.copy.identifier'),
            'consumerSecret'    => config('services.copy.secret'),
            'accessToken'       => $data->getIdentifier(),
            'tokenSecret'       => $data->getSecret(),
            'baseFolder'        => config('services.copy.baseFolder')
        ];

        return json_encode($settings);
    }

}