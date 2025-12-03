<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends BaseController
{
    public function submitApi(Request $request)
    {
        try {
            // 1. Validasi input
            $data = $request->validate([
                'name'    => ['required', 'string', 'max:255'],
                'email'   => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string'],
            ]);

            // 2. Simpan ke database
            $contact = ContactMessage::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'subject'    => $data['subject'],
                'message'    => $data['message'],
                'status'     => 'new',
                'source'     => 'website',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

        // 2) Kirim email ke admin
        $adminEmail = 'theo@example.com'; // yg sudah verified di SES
        Mail::to($adminEmail)->send(new ContactAdminMail($data));

        // 3) (Opsional) email konfirmasi ke user
        // Mail::to($data['email'])->send(new ContactUserMail($data));

                // 4. Balasan sukses ke client
                return $this->success(
                    [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                    ],
                    'Pesan Anda sudah tersimpan dan terkirim. Balasan akan dikirim maksimal 1×24 jam (hari kerja).',
                    201
                );
            } catch (Throwable $e) {
            // 5. Tangani error tak terduga
        return $this->internalError($e, 'Terjadi kesalahan saat memproses pesan Anda');
        }
    }
}
