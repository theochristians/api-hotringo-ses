<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Throwable;

/**
 * Class BaseController
 *
 * Controller dasar untuk semua endpoint API.
 *
 * Tujuan:
 * - Menyediakan format respons JSON yang konsisten.
 * - Mengurangi duplikasi kode di setiap controller (success/error).
 *
 * Pola respons standar:
 *  {
 *      "success": true/false,
 *      "message": "deskripsi singkat",
 *      "data": {...} / null,
 *      "errors": {...} / null
 *  }
 */
abstract class BaseController extends Controller
{
    /**
     * Respons untuk permintaan yang BERHASIL.
     *
     * Contoh penggunaan:
     *  return $this->success($user, 'User berhasil dibuat', 201);
     *
     * @param  mixed       $data    Data yang ingin dikirim ke client.
     * @param  string      $message Pesan singkat.
     * @param  int         $status  HTTP status code (default: 200).
     * @return JsonResponse
     */
    protected function success(
        mixed $data = null,
        string $message = 'Success',
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
        ], $status);
    }

    /**
     * Respons untuk permintaan yang GAGAL karena input / bisnis (4xx).
     *
     * Contoh:
     *  return $this->fail('Data tidak ditemukan', 404);
     *  return $this->fail('Validasi gagal', 422, $validator->errors());
     *
     * @param  string      $message Pesan error yang ingin ditampilkan.
     * @param  int         $status  HTTP status code (default: 400).
     * @param  mixed       $errors  Detail error.
     * @return JsonResponse
     */
    protected function fail(
        string $message = 'Bad request',
        int $status = 400,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
            'errors'  => $errors,
        ], $status);
    }

    /**
     * Respons untuk ERROR INTERNAL SERVER (500).
     *
     * Disarankan dipakai di dalam try/catch,
     * agar error tidak bocor ke client, tapi tetap bisa di-log.
     *
     * Contoh:
     *  try {
     *      ...
     *  } catch (\Throwable $e) {
     *      return $this->internalError($e, 'Gagal memproses permintaan');
     *  }
     *
     * @param  Throwable|string  $e       Exception atau pesan singkat.
     * @param  string            $message Pesan generik untuk client.
     * @return JsonResponse
     */
    protected function internalError(
        Throwable|string $e,
        string $message = 'Internal server error'
    ): JsonResponse {
        if ($e instanceof Throwable) {
            logger()->error($e->getMessage());
        } else {
            logger()->error($e);
        }

        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
            'errors'  => null,
        ], 500);
    }
}
