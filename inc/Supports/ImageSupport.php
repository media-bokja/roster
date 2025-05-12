<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Modules\CustomFields;

use function Bojka\Roster\Facades\rosterGet;

class ImageSupport
{
    public const SIZE_FULL      = 720;
    public const SIZE_MIDIUM    = 480;
    public const SIZE_THUMBNAIL = 240;

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
     *     medium: array{
     *          file: string,
     *          filesize: int,
     *          height: int,
     *          mime-type: string,
     *          path: string,
     *          width: int,
     *      },
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
        if ($size['width'] > self::SIZE_FULL || $size['height'] > self::SIZE_FULL) {
            $result = $editor->resize(self::SIZE_FULL, self::SIZE_FULL);
            if (is_wp_error($result)) {
                wp_die($result);
            }
        }

        $editor->maybe_exif_rotate();

        // Save as webp format.
        $output['full'] = $editor->save($outputPath, 'image/webp');

        $dir      = dirname($outputPath);
        $filename = pathinfo($outputPath, PATHINFO_FILENAME);
        $editor   = wp_get_image_editor($outputPath);

        // Create meduum image
        $editor->resize(self::SIZE_MIDIUM, self::SIZE_MIDIUM);
        $output['medium'] = $editor->save("$dir/$filename-medium.webp");

        // Create thumbnail image.
        $editor->resize(self::SIZE_THUMBNAIL, self::SIZE_THUMBNAIL);
        $output['thumbnail'] = $editor->save("$dir/$filename-thumbnail.webp");

        // Change pathes, relative to the upload directory.
        $output['full']['path']      = _wp_relative_upload_path($output['full']['path']);
        $output['medium']['path']    = _wp_relative_upload_path($output['medium']['path']);
        $output['thumbnail']['path'] = _wp_relative_upload_path($output['thumbnail']['path']);

        return $output;
    }

    public function removeImage(int $postId): void
    {
        $meta   = rosterGet(CustomFields::class);
        $images = $meta->profileImage->get($postId);

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
