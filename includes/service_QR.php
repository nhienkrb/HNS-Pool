<?php

require "vendor/autoload.php";

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

$text = $_POST["text"] ?? 'Hello world!';

// ✅ Tạo QrCode object
$qrCode = new QrCode(
    data: $text,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    foregroundColor: new Color(0, 0, 0),
    backgroundColor: new Color(255, 255, 255)
);


$label = new Label(
    text: 'Info',
    textColor: new Color(255, 0, 0)
);

$writer = new PngWriter();
$result = $writer->write($qrCode, $logo, $label);

header('Content-Type: ' . $result->getMimeType());
echo $result->getString();

$result->saveToFile(__DIR__ . '/qrcode.png');

