<?php namespace Nimbus\Storages;

use Nimbus\Users\User;
use \DB;

class StorageRepository {

    public function saveCredentials($userId, $credentials)
    {
        $credentials = new Storage(compact('credentials'));

        return User::findOrFail($userId)
                        ->storages()
                        ->save($credentials);
    }

    public function testAndStoreCredentials($userId, $credentials)
    {
        $testing = filesystem()->init($credentials);

        try
        {
            $testing->listContents();

            // If that didn't break anything continue...
            $this->saveCredentials($userId, $credentials);

            return true;

        } catch( \Exception $e)
        {
            return false;
        }
    }

    public function destroy($storageId, $userId)
    {
        $storage = Storage::where('user_id', '=', $userId)
                            ->findOrFail($storageId);

        // Remove all the files

        // Remove all the Droplets
        DB::table('droplets')->where('storage_id', '=', $storageId)->delete();

        $storage->delete();

        return;
    }
}