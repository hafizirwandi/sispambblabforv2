<?php

namespace App\Support;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrGenerator
{
    public static function dataUri(string $data, int $size = 200): string
    {
        $qrCode = new QrCode(data: $data, size: $size, margin: 0);

        return (new PngWriter())->write($qrCode)->getDataUri();
    }
}
