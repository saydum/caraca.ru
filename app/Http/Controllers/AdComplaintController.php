<?php

namespace App\Http\Controllers;

use App\Mail\AdComplaintNotification;
use App\Models\Ads;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AdComplaintController extends Controller
{
    public function store(Request $request, Ads $ad)
    {
        $request->validate([
            'complaint_text' => 'required|string|max:2000',
        ]);

        $adUrl = route('ads.show', $ad->id); // ссылка на объявление
        $complaintText = $request->input('complaint_text');
        $userEmail = $request->user()->email;

        Mail::to(config('mail.from.address'))->send(
            new AdComplaintNotification($adUrl, $complaintText, $userEmail)
        );

        return back()->with('success', 'Жалоба отправлена администратору.');
    }
}
