<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseModel
 *
 * Dijadikan kelas dasar (base) untuk semua model Eloquent.
 *
 * Fitur utama:
 * - Menggunakan kolom id (default Laravel: $table->id())
 * - Menggunakan timestamps bawaan Laravel (created_at, updated_at)
 * - Menyimpan informasi siapa yang membuat (created_by)
 *   dan siapa yang terakhir mengubah (updated_by)
 * - Melindungi kolom-kolom audit agar tidak bisa di-mass assign
 */
abstract class BaseModel extends Model
{
    use HasFactory;

    /**
     * Kolom yang TIDAK boleh di-mass assign.
     *
     * Artinya: kalau di controller kamu pakai:
     *   Model::create($request->all());
     * atau:
     *   $model->update($request->all());
     *
     * field-field di dalam $guarded ini TIDAK akan bisa diisi
     * langsung dari input user. Ini penting untuk melindungi
     * kolom audit (supaya user tidak bisa manipulasi created_by, dsb.).
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    /**
     * Casting kolom tanggal.
     *
     * Dengan ini, ketika kamu akses:
     *   $model->created_at
     * atau:
     *   $model->updated_at
     *
     * nilainya akan berupa objek Carbon (datetime),
     * bukan sekadar string biasa.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Event model Eloquent.
     *
     * Method booted() akan dipanggil ketika model inisialisasi.
     * Di sini kita daftarkan "hook" untuk 2 peristiwa:
     *
     * - creating: dipanggil sekali saat data pertama kali dibuat (INSERT)
     * - updating: dipanggil setiap kali data diubah (UPDATE)
     *
     * Tujuan:
     * - Saat create  → set kolom created_by
     * - Saat update  → set kolom updated_by
     */
    protected static function booted(): void
    {
        // Event: sebelum INSERT (creating)
        static::creating(function (BaseModel $model) {
            // Hanya di-set kalau ada user yang sedang login
            if (Auth::check()) {
                // created_by akan diisi dengan nama user yang login,
                // kalau name tidak ada, fallback ke ID user.
                //
                // Operator ??= artinya:
                //   "kalau created_by masih null, isi dengan nilai ini"
                $model->created_by ??= Auth::user()->name
                    ?? (string) Auth::id();
            }
        });

        // Event: sebelum UPDATE (updating)
        static::updating(function (BaseModel $model) {
            // Untuk updated_by, kita isi setiap kali ada perubahan,
            // selama ada user yang login.
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name
                    ?? (string) Auth::id();
            }

            // Catatan:
            // - created_at dan created_by TIDAK diubah di sini,
            //   jadi jejak "siapa & kapan pertama kali membuat"
            //   akan tetap sama.
            // - updated_at akan otomatis di-update oleh Laravel,
            //   karena model menggunakan timestamps default.
        });
    }

    /**
     * Scope opsional: urutkan data dari yang terbaru dulu (created_at desc).
     *
     * Contoh penggunaan:
     *
     *   ContactMessage::latestFirst()->get();
     *
     * Sama saja dengan:
     *
     *   ContactMessage::orderBy('created_at', 'desc')->get();
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('created_at');
    }
}
