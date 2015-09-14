<?php namespace Nimbus\Presenters;

use Laracasts\Presenter\Presenter;
use \Auth, \Crypt;
use League\Glide\Http\UrlBuilderFactory;

class FilePresenter extends Presenter {

    public function downloadPath()
    {
        $details = [
            'file_id'   => $this->id,
            'droplet_id'  => $this->droplet_id,
            'user_id'   => Auth::id()
        ];

        return route('download_file_path', Crypt::encrypt( json_encode($details) ));
    }

    public function downloadCount()
    {
        $count = $this->entity->downloads()->count();

        $plural = str_plural('Download', $count);

        return "{$count} {$plural}";
    }

    public function previewPath($preset = 'lightbox')
    {
        if( ! $this->entity->isImage()) return null;

        // Glide stuff here...
        $urlBuilder = UrlBuilderFactory::create( url('/img') );

        return $urlBuilder->getUrl($this->entity->droplet->present()->directory() . '/' . $this->file_name, $this->buildParams($preset));
    }

    private function buildParams($preset)
    {
        $params = config('glide.presets.' . $preset);

        //if( ! empty($params['use_watermark']))
        //{
        //    unset($params['use_watermark']);
        //
        //    if( is_a($this->entity, 'Snapstacks\Snaps\Snap') && ! empty($this->stack->watermark))
        //    {
        //        $params = array_merge($params,[
        //            'mark'  => '/' . $this->stack->reference . '/' . $this->stack->watermark,
        //            'markscale' => $this->stack->watermark_scale,
        //            'markalign' => $this->stack->watermark_align
        //        ]);
        //    }
        //
        //
        //}


        return $params;
    }
}