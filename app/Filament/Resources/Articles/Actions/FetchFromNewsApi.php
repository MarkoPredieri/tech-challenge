<?php
//CREO UNA ACTION APPOSITA PER L'ESTRAZIONE CASUALE DI NEWS DA NEWSAPI
namespace App\Filament\Resources\Articles\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;


class FetchFromNewsApiAction
{
    public static function make(): Action
    {
        return Action::make('fetchFromNewsApi')
            //LABEL BOTTONE
            ->label('Importa da NewsAPI')
            //ICONA BOTTONE
            ->icon('fas-newspaper')
            ->action(function (Set $set) {
                //ESEGUO LA RICHIESTA ALL'API ESTERNA
                try {
                    $response = Http::retry(3, 200)->get('https://newsapi.org/v2/top-headlines', [
                        'country' => 'us',
                        'apiKey'  => config('services.newsapi.key'),
                    ]);
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Errore di connessione')
                        ->body('Impossibile contattare NewsAPI dopo 3 tentativi. Riprovare più tardi.')
                        ->danger()
                        ->send();
                    return;
                }
                
                //CONVERTO IL RISULTATO JSON IN COLLECTION LARAVEL E FACCIO IN MODO DI AVERE SOLO ELEMENTI CON TITOLO E CONTENUTO NON VUOTI
                $articles = collect($response->json('articles'))
                    ->filter(fn($a) => !empty($a['title']) && !empty($a['content']))
                    ->values();

                //CONTROLLO CHE LA COLLECTION GENERATA NON SIA VUOTA, IN CASO POSITIVO ANNULLO L'OPERAZIONE
                if ($articles->isEmpty()){
                    Notification::make()
                        ->title('Nessun articolo trovato')
                        ->body('L\'API non ha restituito risultati validi. Riprovare più tardi.')
                        ->danger()
                        ->send();
                    return;
                }

                //ESTRAGGO UN ELEMENTO CASUALE DALLA COLLECTION PRECEDENTEMENTE GENERATA (CHE SARA QUELLA USATA PER POPOLARE I CAMPI DEL FORM)
                $article = $articles->random();

                //RIEMPIO I CAMPI DEL FORM CON I DATI DELL'ARTCICOLO, SE NON TROVO DATA DI PUBBLICAZIONE USO IL TIMESTAMP CORRENTE
                $set('title', $article['title']);
                $set('body', $article['content']);
                $set('published_at', $article['publishedAt'] ?? now());
            });
    }
}
