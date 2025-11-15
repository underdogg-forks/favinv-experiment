<?php

namespace App\Http\Controllers\Common;

use App\Facades\Attach;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    /**
     * Preview a file with security validation.
     *
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function previewFile(Request $request)
    {
        $path = $request->input('path');

        // Security: Validate the path to prevent directory traversal attacks
        if (! $this->isValidPath($path)) {
            abort(403, 'Invalid file path');
        }

        // Security: Ensure file exists and is accessible
        if (! Attach::exists($path)) {
            abort(404, 'File not found');
        }

        $fileStream = Attach::readStream($path);
        $fileMetadata = Attach::getMetadata($path);
        $fileName = basename($path);

        // Security: Sanitize filename to prevent header injection
        $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);

        return response()->stream(function () use ($fileStream) {
            fpassthru($fileStream);
        }, 200, [
            'Content-Type' => $fileMetadata['type'],
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Validate file path to prevent directory traversal attacks.
     *
     * @param  string  $path
     * @return bool
     */
    private function isValidPath($path)
    {
        if (empty($path)) {
            return false;
        }

        // Reject paths with directory traversal sequences
        if (preg_match('/\.\./', $path)) {
            return false;
        }

        // Reject absolute paths outside the storage directory
        $realPath = realpath(storage_path($path));
        $storagePath = realpath(storage_path());

        if ($realPath === false || strpos($realPath, $storagePath) !== 0) {
            return false;
        }

        return true;
    }
}
