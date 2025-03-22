<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends Controller
{
    public function viewPdf($filename)
    {
        // Define the path to the PDF file
        $path = storage_path('app/public/quebank/' . $filename);

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Get the file content
        $file = file_get_contents($path);

        // Define the response headers
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ];

        // Return the response with the file content and headers
        return response($file, 200, $headers);
    }
}
