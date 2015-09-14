<?php namespace Nimbus\Droplets;

use Nimbus\Mailers\DropletMailer;
use Nimbus\Users\User;
use \Crypt;

class DropletRepository {

    /**
     * @var DropletMailer
     */
    private $dropletMailer;

    function __construct(DropletMailer $dropletMailer)
    {
        $this->dropletMailer = $dropletMailer;
    }

    public function getById($dropletId)
    {
        return Droplet::findOrFail($dropletId);
    }

    public function getByHash($uploadHash)
    {
        return Droplet::where('upload_hash', '=', $uploadHash)
                        ->firstOrFail();
    }

    public function getBySlug($slug)
    {
        return Droplet::where('slug', '=', $slug)
            ->firstOrFail();
    }

    public function getOrCreateByHash($upload_hash, $user_id)
    {
        $storage_id = User::findOrFail($user_id)->storage('id');

        return Droplet::firstOrCreate(compact('upload_hash', 'user_id', 'storage_id'));
    }

    public function getPaginatedForUser($userId)
    {
        return User::findOrFail($userId)
                    ->droplets()
                    ->latest()
                    ->paginate();
    }

    public function update($dropletId, $formData)
    {
        $droplet = $this->getById($dropletId);

        $droplet->fill($formData);

        $droplet->save();

        return;
    }

    public function updateSecurity($dropletId, $formData)
    {
        $droplet = $this->getById($dropletId);

        // Password protection
        if(isset($formData['use_password']))
        {
            if( ! empty($formData['password']))
            {
                $droplet->password = Crypt::encrypt($formData['password']);
            }
        } else
        {
            $droplet->password = null;
        }

        // Download limits
        if(isset($formData['use_limit']))
        {
            $droplet->limit = $formData['limit'];
        } else
        {
            $droplet->limit = null;
        }

        // Start and finish dates
        if(isset($formData['use_expiry']))
        {
            $droplet->start_at = ( ! empty($formData['start_at'])) ? $formData['start_at'] : null;
            $droplet->finish_at = ( ! empty($formData['finish_at'])) ? $formData['finish_at'] : null;
        } else
        {
            $droplet->start_at = $droplet->finish_at = null;
        }


        $droplet->save();

        return;
    }

    public function sendShareEmails($dropletId, $formData)
    {
        $droplet = $this->getById($dropletId);

        $emails = explode(',', $formData['emails']);

        $this->dropletMailer->sendShareEmailsTo($emails, $droplet, $droplet->user, $formData['message']);

        return count($emails);
    }

    public function destroy($dropletId, $userId)
    {
        $droplet = Droplet::where('user_id', '=', $userId)->findOrFail($dropletId);

        // Remove all of the files

        $droplet->delete();

        return true;
    }
}