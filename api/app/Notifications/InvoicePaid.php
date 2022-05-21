<?php

namespace App\Notifications;

use App\Models\SalesDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    protected $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SalesDetails $customer)
    {
        //
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage) ->greeting('Hello!, '.$this->customer->customer_name)
                                 ->line('Pembelian kendaraan di toko kami sudah lunas, adapun jenis kendaraan yang anda beli:')
                                 ->line('Nama Kendaraan : '.$this->customer->car_name)
                                 ->line('Harga          : '.number_format($this->customer->car_price, 2))
                                 ->line('Jumlah         : 1')
                                 ->line('')
                                 ->line('')
                                 ->line('Terima kasih sudah berbelanja di toko kami');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
