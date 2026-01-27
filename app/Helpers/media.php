<?php

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

if (!function_exists('get_media_url')) {
    /**
     * Get the URL for a media record or path from MinIO.
     * 
     * @param mixed $media The Media model instance, a media ID, or a string file path.
     * @param string $default The default image path if media is not found.
     * @return string
     */
    function get_media_url($media, string $default = 'img/no-image.png'): string
    {
        if ($media instanceof Media) {
            return $media->url;
        }

        if (is_numeric($media)) {
            $mediaRecord = Media::find($media);
            return $mediaRecord ? $mediaRecord->url : asset($default);
        }

        if (is_string($media) && !empty($media)) {
            // If it's already a full URL (http:// or https://)
            if (str_starts_with($media, 'http://') || str_starts_with($media, 'https://')) {
                return $media;
            }

            // Assume it's a relative path in the minio disk
            try {
                return Storage::disk('minio')->url($media);
            } catch (\Exception $e) {
                return asset($default);
            }
        }

        return asset($default);
    }
}
