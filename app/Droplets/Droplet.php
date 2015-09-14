<?php namespace Nimbus\Droplets;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Droplet extends Model {

	use PresentableTrait;

    protected $presenter = 'Nimbus\Presenters\DropletPresenter';

    protected $fillable = ['user_id', 'storage_id', 'upload_hash', 'slug', 'title', 'introduction', 'watermark_images'];

    protected $dates = ['start_at', 'finish_at'];

    public function user()
    {
        return $this->belongsTo('Nimbus\Users\User');
    }

    public function files()
    {
        return $this->hasMany('Nimbus\Files\File');
    }

    public function storage()
    {
        return $this->belongsTo('Nimbus\Storages\Storage');
    }

    public static function create(array $attributes)
    {
        $length = 6;

        do
        {
            $attributes['slug'] = str_random($length);

            $exists = static::where('slug', '=', $attributes['slug'])->first();

            $length++;
        } while( ! empty( $exists ));

        return parent::create($attributes);
    }

    public function canBeUploadedTo()
    {
        return (bool) ($this->storage_id || $this->files()->count() < 10);
    }

    public function filesystem()
    {
        if( ! empty($this->storage_id)) return $this->storage->credentials;

        return env('DEFAULT_FILESYSTEM');
    }
}
