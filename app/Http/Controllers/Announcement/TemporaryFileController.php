<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TemporaryFileController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'kode' => 400,
                'data' => $validator->errors()->first(),
                'message' => 'hanya file .png .jpg dan .jpeg saja'
            ], 400);
        }

        if ($request->isMethod('delete')) {
            $filepond = $request->json()->all();
            $folder = $filepond['folder'];
            $tempFile = TemporaryFile::query()->where('folder', $folder)->first();
            $path = storage_path('app/orders/temp/' . $folder);
            if (is_dir($path) && $tempFile) {
                DB::beginTransaction();

                try {
                    unlink($path . '/' . $tempFile->filename);
                    rmdir($path);
                    $tempFile->delete();
                    DB::commit();

                    return response()->json(['message' => 'success']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error deleting directory: ' . $e->getMessage());
                    return response()->json(['message' => 'failed'], 500);
                }
            }
            return response()->json(['message' => 'failed'], 500);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . time();

            // Pastikan direktori penyimpanan ada
            if (!file_exists(storage_path('app/orders/temp/' . $folder))) {
                mkdir(storage_path('app/orders/temp/' . $folder), 0777, true);
            }

            // Simpan file
            $file->storeAs('orders/temp/' . $folder, $filename);

            // Simpan informasi file ke database
            TemporaryFile::create(['folder' => $folder, 'filename' => $filename]);

            // Mengembalikan folder yang dibuat
            return response()->json(['folder' => $folder], 200);
        }
    }
}
