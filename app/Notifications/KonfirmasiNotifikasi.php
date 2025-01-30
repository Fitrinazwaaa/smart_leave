<?php

namespace App\Notifications;

use App\Models\Dispensasi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KonfirmasiNotifikasi extends Notification
{
    use Queueable;

    public $dispensasi;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Dispensasi  $dispensasi
     * @return void
     */
    public function __construct(Dispensasi $dispensasi)
    {
        $this->dispensasi = $dispensasi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Anda dapat mengirim via email, database, atau lainnya
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengajuan Dispensasi Baru')
            ->line('Ada pengajuan dispensasi baru dari siswa.')
            ->line('Nama Siswa: ' . $this->dispensasi->nama)
            ->line('Kategori: ' . $this->dispensasi->kategori)
            ->line('Waktu Keluar: ' . $this->dispensasi->waktu_keluar)
            ->action('Lihat Detail', url('/dashboard/dispensasi/' . $this->dispensasi->id_dispen))
            ->line('Terima kasih telah menggunakan sistem dispensasi.');
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
            'id_dispen' => $this->dispensasi->id_dispen,
            'nama_siswa' => $this->dispensasi->nama,
            'kategori' => $this->dispensasi->kategori,
            'waktu_keluar' => $this->dispensasi->waktu_keluar,
        ];
    }
}
