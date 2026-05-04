<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendGmailRequest;
use App\Mail\SendGmail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\ResponsHelper;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function sendGmail(SendGmailRequest $request)
    {
        try {
            $data = $request->validated();
            Mail::to($data['to'])->send(new SendGmail($data['subject'], $data['body']));
            return ResponsHelper::success(null, 'Email sent successfully');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email: ' . $e->getMessage());
            return ResponsHelper::error('Gagal mengirim email: ' . $e->getMessage(), 500);
        }
    }
}
