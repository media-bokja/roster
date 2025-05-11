<?php

namespace Bojka\Roster\Supports;

class ImageSupport
{
    public static function getUploadDir(): string
    {
        $d   = wp_get_upload_dir();
        $dir = path_join($d['basedir'], 'bojka-roster');
        $rel = wp_date('/Y/m');

        return $dir . $rel;
    }

    /**
     * @param string $inputPath
     * @param string $outputPath
     *
     * @return array{
     *     full: array{
     *         file: string,
     *         filesize: int,
     *         height: int,
     *         mime-type: string,
     *         path: string,
     *         width: int,
     *     },
     *     thumbnail: array{
     *         file: string,
     *         filesize: int,
     *         height: int,
     *         mime-type: string,
     *         path: string,
     *         width: int,
     *     },
     * }
     */
    public function processImage(string $inputPath, string $outputPath): array
    {
        $output = [];

        $editor = wp_get_image_editor($inputPath);
        if (is_wp_error($editor)) {
            wp_die($editor);
        }

        // Resize if it is too larget.
        $size = $editor->get_size();
        if ($size['width'] > 700 || $size['height'] > 700) {
            $result = $editor->resize(700, 700);
            if (is_wp_error($result)) {
                wp_die($result);
            }
        }

        $editor->maybe_exif_rotate();

        // Save as webp format.
        $output['full'] = $editor->save($outputPath, 'image/webp');

        // Create thumbnail image.
        $editor = wp_get_image_editor($outputPath);
        $editor->resize(200, 200);

        // Save
        $dir                 = dirname($outputPath);
        $filename            = pathinfo($outputPath, PATHINFO_FILENAME);
        $resizedPath         = $dir . '/' . $filename . '-thumbnail.webp';
        $output['thumbnail'] = $editor->save($resizedPath);

        // Change pathes, relative to the upload directory.
        $output['full']['path']      = _wp_relative_upload_path($output['full']['path']);
        $output['thumbnail']['path'] = _wp_relative_upload_path($output['thumbnail']['path']);

        return $output;
    }

    public function removeImage(array $images): void
    {
        if (!$images) {
            return;
        }

        $uploads = wp_get_upload_dir();

        foreach ($images as $image) {
            $path = $image['path'] ?? '';
            if (!$path) {
                continue;
            }

            $path = path_join($uploads['basedir'], $path);
            if (file_exists($path) && is_file($path)) {
                @unlink($path);
            }
        }
    }
}
