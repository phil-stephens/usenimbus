<?php namespace Nimbus\Presenters;

use Laracasts\Presenter\Presenter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;

class DropletPresenter extends Presenter {

    public function directory()
    {
        $credentials = json_decode($this->entity->filesystem());
        $prefix = ( isset($credentials->baseFolder)) ? $credentials->baseFolder : '';

        return $prefix . $this->slug;
    }

    public function fileCount()
    {
        $count = $this->entity->files()->count();

        $plural = str_plural('File', $count);

        return "{$count} {$plural}";
    }

    public function title($before = '', $after = '', $showOnEmpty = true)
    {
        if( ! empty($this->entity->title)) return $before . $this->entity->title . $after;

        if($showOnEmpty)
        {
            if( ! $this->entity->files()->count()) return $before . 'Empty Droplet' . $after;

            $file_name = $this->entity->files->first()->file_name;

            $count = $this->entity->files()->count();

            $count--;

            $title = $file_name;

            if($count > 0)
            {
                $plural = str_plural('file', $count);

                $title .= " plus {$count} other {$plural}";
            }

            return $before . $title . $after;
        }

        return;
    }

    public function htmlIntroduction($before = '', $after = '')
    {
        $introduction = trim($this->introduction);

        if(empty( $introduction )) return;

        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $htmlRenderer = new HtmlRenderer($environment);

        $text = $parser->parse($introduction);
        return $before . $htmlRenderer->renderBlock($text) . $after;
    }
}