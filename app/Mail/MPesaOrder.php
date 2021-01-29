<?php

namespace App\Mail;

use App\FPDF\FPDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MPesaOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fpdf = new FPDF('L', 'mm', array(150, 200));
        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 10);
        $fpdf->Image(public_path('logo.png'), 120, 3, 50, 25);
        $qrname = 'toffeeTicket-'.$this->order->order_number;
        $path = public_path('qr-codes/qr2-'.$qrname . '.png');
        $image = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->color(26,144,130)
            ->size(500)
            ->generate($this->order->order_number, $path);
        //QR CODE
        $fpdf->setXY(29, 56);
        $fpdf->Cell(0, 0, 'ORDER NUMBER: ' . $this->order->order_number);
        $fpdf->Image($path , 31, 58, 50 ,50);
        $fpdf->setXY(29, 22);
        //Package Name
        $fpdf->Cell(0, 0,'Package Type: ' . $this->order->package->name);

        //Ticket Owner
        $fpdf->setXY(29, 26);
        $fpdf->Cell(0, 0, 'Ticket Owner: ' . $this->order->user->full_name .' '.'(' .$this->order->user->phone_number.').');
        $fpdf->setXY(29, 30);
        $fpdf->Cell(0, 0, 'Email: ' . $this->order->user->email);

        //Dates
        $fpdf->setXY(29, 38);
        $fpdf->Cell(0, 0, 'Valid From:'.\Illuminate\Support\Carbon::parse($this->order->created_at)->format('d M Y, h:i') .' Expires at:' . \Illuminate\Support\Carbon::parse($this->order->expires_at)->format('d M Y, h:i'));
        $fpdf->setXY(29 , 50);
        $fpdf->Cell(0, 0, 'Paid Amount: KSH' .": ". number_format($this->order->amount));

        $fpdf->SetFont('Courier', 'B', 12);
        $fpdf->setXY(80, 68);
        $fpdf->Cell(0, 0, 'PAID');
        $fpdf->SetFont('Courier', '',11);
        $fpdf->setXY(80, 75);
        $fpdf->Cell(0, 0, 'YOU MAY PRINT OR DISPLAY THIS TICKET AT');
        $fpdf->setXY(80, 80);
        $fpdf->Cell(0, 0, 'THE LOCATION. DUBLICATES');
        $fpdf->setXY(80, 85);
        $fpdf->Cell(0, 0, 'WILL BE DETECTED AND REJECTED. ');
        $fpdf->setXY(80, 90);
        $fpdf->Cell(0, 0, 'ANY QUESTION ABOUT YOUR TICKET? ');
        $fpdf->setXY(80, 95);
        $fpdf->Cell(0, 0, 'EMAIL US AT info@toffetribe.com');
        $fpdf->setXY(80, 100);
        $fpdf->Cell(0, 0, 'DO NOT SHARE YOUR QR-CODE.');
        $file_name = $qrname. '.pdf';
        $file_dir = public_path('qr-codes/'.$file_name);

        $fpdf->Output($file_dir, 'F');

        return $this->from("info@toffeetribe.com", "Toffee Tribe")
//            ->to($this->order->user->email, $this->order->user->full_name)
            ->Subject('Your TOFFEE TRIBE Subscription Purchase')
            ->markdown('Emails.mpesa-order')
            ->attach(public_path('qr-codes/'.'toffeeTicket-'.$this->order->order_number.'.pdf'));
    }
}
