<?php namespace Nimbus\Glide\Manipulator;

use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Request;
use League\Glide\Api\Manipulator\ManipulatorInterface;

class Watermark implements ManipulatorInterface
{

    /**
     * @var
     */
    private $filesystem;

    /**
     * mark - file path
     * markalign - <unset> (top, right), top, middle, bottom, left, center, right
     * markfit - clip, max, fill, crop, and scale
     * markh
     * markw
     * markpad - default 10
     * markscale - scales to % of source images width
     */
    function __construct($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Perform image manipulations.
     * @param  Request $request The request object.
     * @param  Image $image The source image.
     * @return Image   The manipulated image.
     */
    public function run(Request $request, Image $image)
    {
        //die('watermarking');
        // Get the image source of the mark
        if( ! $mark = $this->getMark($request->get('mark')))
        {
            return $image;
        }

        // Still here? Cool...

        // Get the position
        $position = $this->resolvePosition($request->get('markalign'));

        $padding = $this->getMarkPadding($request->get('markpad'));

        if($scale = $this->getMarkScale($request->get('markscale')))
        {
            $mark->resize(round( $image->width() * ($scale / 100) ),
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                });
        }

        // Insert the watermark
        $image->insert($mark, $position, $padding, $padding);

        // Continue
        return $image;
    }

    public function getMark($path)
    {
        if (is_null($path) || empty($path)) {
            return false;
        }

        // Now check that we can actually get the file
        try
        {
            $markSource = $this->filesystem->read($path);

            \Image::configure(array('driver' => env('INTERVENTION_DRIVER', 'gd')));

            return \Image::make($markSource);
        } catch( \Exception $e)
        {

        }

        return false;
    }

    public function resolvePosition($align)
    {
        if (is_null($align)) {
            return 'bottom-right';
        }

        $align = preg_replace('/\s+/', '', $align);

        switch($align)
        {

            case 'middle,center':
            case 'center,middle':
            case 'middle':
            case 'center':
                return 'center';
                break;

            // Top alignment
            case 'top':
            case 'top,center':
            case 'center,top':
                return 'top';
                break;

            case 'top,left':
            case 'left,top':
                return 'top-left';

            case 'top,right':
            case 'right,top':
                return 'top-right';

            // Bottom alignment
            case 'bottom':
            case 'bottom,center':
            case 'center,bottom':
                return 'bottom';
                break;

            case 'bottom,left':
            case 'left,bottom':
                return 'bottom-left';

            case 'bottom,right':
            case 'right,bottom':
                return 'bottom-right';
                break;

            // Left alignment
            case 'left':
            case 'left,middle':
            case 'middle,left':
                return 'left';
                break;

            // Right alignment
            case 'right':
            case 'right,middle':
            case 'middle,right':
                return 'right';
                break;


            default:
                return 'bottom-right';
                break;
        }
    }

    public function getMarkWidth($width)
    {
        if (is_null($width)) {
            return false;
        }

        if (!ctype_digit($width)) {
            return false;
        }

        return (double) $width;
    }

    public function getMarkHeight($height)
    {
        if (is_null($height)) {
            return false;
        }

        if (!ctype_digit($height)) {
            return false;
        }

        return (double) $height;
    }

    public function getMarkScale($scale)
    {
        if (is_null($scale)) {
            return false;
        }

        if (!ctype_digit($scale)) {
            return false;
        }

        return (double) $scale;
    }
    public function getMarkPadding($padding)
    {
        if (is_null($padding)) {
            return 5;
        }

        if (!ctype_digit($padding)) {
            return false;
        }

        return (double) $padding;
    }

}