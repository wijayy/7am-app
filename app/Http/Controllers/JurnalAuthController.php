<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JurnalAuthController extends Controller
{
    public function redirectToJurnal()
    {
        $clientId = config('mekari.client_id');
        $redirectUri = config('mekari.jurnal_redirect');
        $authorizeUrl = "https://account.mekari.com/auth";
        $scopes = 'products sales_invoices';

        $url = "{$authorizeUrl}?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=code&scope={$scopes}";

        return redirect($url);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return redirect()->route('dashboard')->with('error', 'Authorization code tidak ditemukan.');
        }

        $tokenUrl = "https://api.mekari.com/v1/oauth/token";

        $response = Http::asForm()->post($tokenUrl, [
            'client_id' => config('mekari.client_id'),
            'client_secret' => config('mekari.client_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.jurnal.redirect'),
            'code' => $code,
        ]);

        $data = $response->json();

        if ($response->failed()) {
            return redirect()->route('dashboard')->with('error', $data['error_description'] ?? 'Gagal mendapatkan access token.');
        }

        // Simpan ke session (bisa juga ke database)
        Session::put('jurnal_access_token', $data['access_token']);
        Session::put('jurnal_refresh_token', $data['refresh_token']);
        Session::put('jurnal_expires_in', now()->addSeconds($data['expires_in']));

        return redirect()->route('dashboard')->with('success', 'Terhubung ke Jurnal Mekari!');
    }
}
