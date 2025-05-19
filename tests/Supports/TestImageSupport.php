<?php

namespace Bokja\Roster\Tests\Supports;

use Bokja\Roster\Objects\Profile;
use Bokja\Roster\Supports\ImageSupport;

use function Bokja\Roster\Facades\rosterGet;

class TestImageSupport extends \WP_UnitTestCase
{
    public function testImageConvert()
    {
        $inputImage = dirname(__DIR__) . '/fixtures/QR-github-bojaghi.png';

        $support   = rosterGet(ImageSupport::class);
        $uploadDir = $support->getUploadDir();
        $output    = $support->processImage($inputImage, $uploadDir . '/output.webp');

        $this->assertIsArray($output);

        $this->assertArrayHasKey('full', $output);
        $this->assertArrayHasKey('file', $output['full']);
        $this->assertArrayHasKey('filesize', $output['full']);
        $this->assertArrayHasKey('height', $output['full']);
        $this->assertArrayHasKey('mime-type', $output['full']);
        $this->assertArrayHasKey('path', $output['full']);
        $this->assertArrayHasKey('width', $output['full']);
        $this->assertEquals(720, $output['full']['height']);
        $this->assertEquals(720, $output['full']['width']);
        $this->assertEquals('image/webp', $output['full']['mime-type']);

        $this->assertArrayHasKey('medium', $output);
        $this->assertArrayHasKey('file', $output['medium']);
        $this->assertArrayHasKey('filesize', $output['medium']);
        $this->assertArrayHasKey('height', $output['medium']);
        $this->assertArrayHasKey('mime-type', $output['medium']);
        $this->assertArrayHasKey('path', $output['medium']);
        $this->assertArrayHasKey('width', $output['medium']);
        $this->assertEquals(480, $output['medium']['height']);
        $this->assertEquals(480, $output['medium']['width']);
        $this->assertEquals('image/webp', $output['medium']['mime-type']);

        $this->assertArrayHasKey('thumbnail', $output);
        $this->assertArrayHasKey('file', $output['thumbnail']);
        $this->assertArrayHasKey('filesize', $output['thumbnail']);
        $this->assertArrayHasKey('height', $output['thumbnail']);
        $this->assertArrayHasKey('mime-type', $output['thumbnail']);
        $this->assertArrayHasKey('path', $output['thumbnail']);
        $this->assertArrayHasKey('width', $output['thumbnail']);
        $this->assertEquals(240, $output['thumbnail']['height']);
        $this->assertEquals(240, $output['thumbnail']['width']);
        $this->assertEquals('image/webp', $output['thumbnail']['mime-type']);

        // Check file exists
        $dir           = wp_get_upload_dir();
        $fullPath      = $dir['basedir'] . '/' . $output['full']['path'];
        $thumbnailPath = $dir['basedir'] . '/' . $output['thumbnail']['path'];
        $this->assertFileExists($fullPath);
        $this->assertFileExists($thumbnailPath);

        // Test removeImages
        $profile = new Profile();
        $profile->profileImage = $output;
        $profile->save();

        $support->removeImage($profile->id);
        $this->assertFileDoesNotExist($fullPath);
        $this->assertFileDoesNotExist($thumbnailPath);
    }
}
