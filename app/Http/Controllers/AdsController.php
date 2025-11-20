<?php

namespace App\Http\Controllers;

use App\Enums\AdStatus;
use App\Http\Requests\AdRequest;
use App\Mail\NewAdNotification;
use App\Models\Ads;
use App\Traits\SeoData;
use Illuminate\Support\Facades\Mail;


class AdsController extends Controller
{
    use SeoData;
    public function index()
    {
        $ads = auth()->user()->ads()
            ->where('status', '=', AdStatus::ACTIVE)
            ->paginate(10);
        return view('ads.index', compact('ads'));
    }
    // Просмотр объявления
    public function show($slug)
    {
        $ad = Ads::where('slug', $slug)->firstOrFail();

        $description = mb_substr($ad['description'], 0, 550);

        $stopWords = [
            'и','на','ты','он','она','оно','мы','вы','они',
            'в','во','с','со','по','к','ко','от','до','за',
            'из','у','о','об','обо','для','как','так','же',
            'т','д','тд','т.п','тп','что','это','а','но','или'
        ];

        $words = preg_split('/[\s,.\-!?:;]+/u', mb_strtolower($ad['description']), -1, PREG_SPLIT_NO_EMPTY);

        $filtered = array_diff($words, $stopWords);

        $uniqueWords = array_unique($filtered);

        $keywords = implode(', ', array_slice($uniqueWords, 0, 30));

        $this->setSeoMetaData([
            'title'       => $ad['name'],
            'description' => $description,
            'keywords'    => $keywords,
            'text'        => $ad['description'],
        ]);

        return view('ads.show', compact('ad'));
    }

    public function create()
    {
        return view('ads.create');
    }

    public function store(AdRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = AdStatus::ACTIVE;

        if (empty($data['price'])) {
            $data['price'] = 0;
        }
        if (empty($data['year'])) {
            $data['year'] = \Date::now()->year;
        }

        if ($request->hasFile('images')) {
            $paths = [];

            foreach ($request->file('images') as $file) {
                $path = $file->store('ads', 'public');
                $paths[] = $path;
            }

            $data['images'] = $paths;
        }


        $ad = Ads::create($data);

        Mail::to(config('mail.from.address'))->send(new NewAdNotification($ad));

        return redirect()->route('app')
            ->with('success', 'Объявление создано. Его опубликуют после одобрения администратором, это не долго 😊');
    }

    public function edit(Ads $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function update(AdRequest $request, Ads $ad)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('ads', 'public');
            }
            $data['images'] = $paths;
        }

        $ad->update($data);

        return redirect()->route('app')->with('success', 'Объявление обновлено!');
    }

//    public function destroy(Ads $ad)
//    {
//        $ad->delete();
//        return redirect()->route('app')->with('success', 'Объявление удалено!');
//    }

    public function archive(Ads $ad)
    {
        $ad->update(['status' => 'removed']);
        return redirect()->route('ads.index')->with('success', 'Объявление перенесено в архив!');
    }
}
