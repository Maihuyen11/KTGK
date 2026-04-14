<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccess extends Mailable {
    use Queueable, SerializesModels;
    public $donHang;
    public function __construct($donHang) { $this->donHang = $donHang; }
    public function build() {
        return $this->subject('Xác nhận đặt hàng thành công')
                    ->view('emails.order_success');
    }
}