<?php


namespace App\Service\QrCode;


use App\Entity\Coupons;
use Endroid\QrCode\QrCode;

class QrCodeGenerator
{
    private string $saveDir;

    private string $host;

    public function __construct(string $host)
    {
        $path = __DIR__ . "/../../../public/uploads/files/coupons";
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
        $this->host = $host;
        $this->saveDir = $path;
    }

    public function generateCouponQrCode(Coupons $coupon)
    {
        $qrCode = new QrCode($coupon->getCouponNo());
        $fileName = $coupon->getCouponNo() . ".png";
        $filePath = $this->saveDir . "/" . $fileName;
        $qrCode->writeFile($filePath);
        //返回一个 http地址
        return $this->host . "/uploads/files/coupons/" . $fileName;
    }
}