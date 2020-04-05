<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadInvoiceController extends Controller
{
    public function show($invoiceId)
    {
        $user = Auth::user();

        return $user->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => 'Test',
        ]);
    }
}