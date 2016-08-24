<?php

namespace Yajra\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\CMS\Http\NotificationResponse;
use Symfony\Component\Finder\Finder;

/**
 * Class ImageBrowserController
 *
 * @package Yajra\CMS\Http\Controllers
 */
class ImageBrowserController extends Controller
{
    use NotificationResponse;

    /**
     * Get files by directory path.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function getFiles(Request $request)
    {
        $path       = $request->get('path');
        $mediaFiles = $this->getMediaFiles($path);

        return view('administrator.partials.image-browser.container', compact('mediaFiles', 'path'))->render();
    }

    /**
     * Upload image file.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image',
        ]);
        $filename = $request->file('file')->getClientOriginalName();
        $request->file('file')
                ->move(storage_path('app/' . config('media.root_dir') . $request->get('directory') . '/'), $filename);

        return $this->notifySuccess('Image Successfully Uploaded!');
    }

    /**
     * Show all files on selected path.
     *
     * @param string $currentPath
     * @param array $mediaFiles
     * @return array
     */
    public function getMediaFiles($currentPath = null, $mediaFiles = [])
    {
        $path       = storage_path('app/public/media' . $currentPath);
        $imageFiles = $this->getImageFiles($path);

        foreach (Finder::create()->in($path)->sortByType()->directories() as $file) {
            $imageFiles->name($file->getBaseName());
        }

        foreach ($imageFiles as $file) {
            $mediaFiles[] = [
                'filename' => $file->getFilename(),
                'realPath' => $file->getRealPath(),
                'type'     => $file->getType(),
                'filepath' => str_replace(storage_path('app/public/media'), '', $file->getRealPath()),
            ];
        }

        return $mediaFiles;
    }

    /**
     * Get image files by path.
     *
     * @param string $path
     * @return Finder
     */
    private function getImageFiles($path)
    {
        $finder = Finder::create()->in($path)->sortByType()->depth(0);
        foreach (config('media.images_ext') as $file) {
            $finder->name('*' . $file);
        }

        return $finder;
    }
}
