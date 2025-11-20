<?php

namespace App\Http\Controllers;

use App\Enums\AdStatus;
use App\Enums\ModerationAdStatus;
use App\Models\Ads;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $query = Ads::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'date':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'year':
                    $query->orderBy('year', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        $query
            ->where('status', AdStatus::ACTIVE)
            ->where('moderation_status', '=', ModerationAdStatus::APPROVED)
        ;
        $ads = $query->paginate(12)->appends($request->query());

        return view('app', compact('ads'));
    }
}
