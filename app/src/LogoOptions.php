<?php

namespace SysSoftIntegra\Src;

use chillerlan\QRCode\{QRCode, QROptions};

class LogoOptions extends QROptions
{
    protected int $logoSpaceWidth;
    protected int $logoSpaceHeight;

    public function __construct(int $version = 7, int $eccLevel = QRCode::ECC_H, bool $imageBase64 = true, int $logoSpaceWidth = 13, int $logoSpaceHeight = 13, int $scale = 5, bool $imageTransparent = true)
    {
        $this->version          = $version;
        $this->eccLevel         = $eccLevel;
        $this->imageBase64      = $imageBase64;
        $this->logoSpaceWidth   = $logoSpaceWidth;
        $this->logoSpaceHeight  = $logoSpaceHeight;
        $this->scale            = $scale;
        $this->imageTransparent = $imageTransparent;
    }
}
