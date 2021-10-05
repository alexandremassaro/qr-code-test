<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrinterController extends Controller
{
    public function print() {
        $nombre_impresora = "ELGIN";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        //$image = url('/image/tie.png');
        //$logo = EscposImage::load($image, false);
        //$printer->bitImage($logo);

        $qr_code = 'https://www.clickped.com.br/mesa/1';
        $qr_code_ec = Printer::QR_ECLEVEL_H;
        $qr_code_size = 9;
        $qr_code_model = Printer::QR_MODEL_2;

        $printer->feed();
        $printer->qrCode($qr_code, $qr_code_ec, $qr_code_size, $qr_code_model);
        $printer->feed();

        $printer->setTextSize(2, 2);
        $printer->text("Ticket con PHP");

        $printer->setTextSize(2, 1);
        $printer->feed();
        $printer->text("Hola mundo\n\nParzibyte.me\n\nNo olvides suscribirte");

        $printer->feed(5);


        $printer->cut();


        $printer->pulse();


        $printer->close();
    }
}
