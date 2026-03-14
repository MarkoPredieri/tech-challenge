<?php
//CONTROLLO CHE LA CHIAMATA API AL NEWSAPI MI RESTITUISCA ALMENO UNA NEWS E CHE LA NEWS RESTITUITA ABBIA TITOLO E CONTENUTO NON VUOTI
use Illuminate\Support\Facades\Http;

it('fetches real article from NewsAPI', function () {
    $response = Http::get('https://newsapi.org/v2/top-headlines', [
        'country' => 'us',
        'apiKey'  => config('services.newsapi.key'),
    ]);

    expect($response->successful())->toBeTrue();

    $article = collect($response->json('articles'))
        ->filter(fn($a) => !empty($a['title']) && !empty($a['content']))
        ->first();

    expect($article)->not->toBeNull();
    expect($article['title'])->toBeString()->not->toBeEmpty();
    expect($article['content'])->toBeString()->not->toBeEmpty();
});

