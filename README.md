# Billoo — Tech Challenge

Benvenuto/a! Questa è la repository di partenza per il nostro test tecnico. Contiene un'installazione _fresh_ di **Laravel 12** e tutto ciò che ti serve per cominciare.

Leggi attentamente tutto il documento prima di iniziare.

---

## Stack tecnologico

| Componente   | Versione |
| ------------ | -------- |
| PHP          | ^8.2     |
| Laravel      | ^12.0    |
| DB (default) | SQLite   |

> Le tecnologie indicate sono suggerimenti, non vincoli. Se sei più a tuo agio con MySQL, PostgreSQL o qualsiasi altro strumento, sentiti libero/a di usarlo. Ciò che vogliamo valutare è il tuo approccio, non la tua familiarità con una configurazione specifica.

---

## Requisiti di sistema

- PHP 8.2 o superiore
- Composer
- Node.js e NPM

---

## Esercizi

### Esercizio 1 — Installazione di Filament (Panel Builder)

Installa il pannello di amministrazione **[Filament v5](https://filamentphp.com)** seguendo la [guida ufficiale all'installazione del Panel Builder](https://filamentphp.com/docs/5.x/introduction/installation).

**Riferimenti utili:**

- [Documentazione Filament](https://filamentphp.com/docs)
- [Panel Builder — Installazione](https://filamentphp.com/docs/5.x/introduction/installation)

---

### Esercizio 2 — Modelli, Migration e Seeder

Crea la struttura dati per un semplice catalogo di **articoli** organizzati per **categoria**.

#### Modello `Category`

Campi richiesti:

| Campo         | Tipo    | Note                            |
| ------------- | ------- | ------------------------------- |
| `id`          | integer | chiave primaria, auto-increment |
| `name`        | string  | nome della categoria            |
| `description` | text    | nullable                        |
| `timestamps`  | —       | `created_at` e `updated_at`     |

#### Modello `Article`

Campi richiesti:

| Campo          | Tipo      | Note                              |
| -------------- | --------- | --------------------------------- |
| `id`           | integer   | chiave primaria, auto-increment   |
| `title`        | string    | titolo dell'articolo              |
| `body`         | text      | contenuto                         |
| `category_id`  | foreignId | chiave esterna verso `categories` |
| `published_at` | timestamp | nullable                          |
| `timestamps`   | —         | `created_at` e `updated_at`       |

#### Relazioni Eloquent

- Una `Category` ha molti `Article` → metodo `hasMany`
- Un `Article` appartiene a una `Category` → metodo `belongsTo`

#### Seeder

Crea un seeder (`DatabaseSeeder`) che popoli il database con almeno:

- 5 categorie
- 20 articoli distribuiti tra le categorie

Usa le [Eloquent Factories](https://laravel.com/docs/eloquent-factories) con [Faker](https://fakerphp.github.io/) per generare i dati.

---

### Esercizio 3 — Risorse Filament

Esponi i modelli creati nell'esercizio precedente tramite il pannello Filament creando una [Resource](https://filamentphp.com/docs/5.x/resources/overview) per ciascun modello.

Per ciascuna resource assicurati che:

- La **tabella** (`table()`) mostri le colonne principali (es. `name`, `title`, `category`, `published_at`)
- Il **form** (`form()`) contenga i campi necessari per creare e modificare un record
- La resource per `Article` includa un selettore per scegliere la `Category`

---

### Esercizio 4 — Integrazione con API esterna

Utilizzeremo **[NewsAPI](https://newsapi.org)**, un servizio gratuito (con registrazione) che fornisce articoli di notizie reali.

#### Requisiti

1. Registrati su [https://newsapi.org](https://newsapi.org) e ottieni la tua API key gratuita.

2. Nella pagina di **creazione** di un `Article` nel pannello Filament, aggiungi un'[Action](https://filamentphp.com/docs/panels/actions) (un pulsante) che, quando cliccato, chiami l'endpoint `GET top-headlines` di NewsAPI, scelga casualmente uno degli articoli restituiti e **pre-popoli automaticamente** i campi `title` e `body` del form con i dati ricevuti.

    L'utente potrà poi modificare i campi a piacimento e salvare normalmente il record.

3. Usa l'[HTTP Client di Laravel](https://laravel.com/docs/http-client) per effettuare la chiamata all'API.

**Riferimenti utili:**

- [NewsAPI — Documentazione](https://newsapi.org/docs)
- [Laravel HTTP Client](https://laravel.com/docs/http-client)
- [Filament Actions — Form actions](https://filamentphp.com/docs/5.x/actions/overview)

---

## Esercizio Bonus — Il cuore di Billoo

> Questo esercizio è facoltativo. Non è richiesto per completare la challenge, ma ci interessa molto vedere come ragioni su un problema vicino al nostro dominio.

Billoo nasce per aiutare le persone a capire se stanno pagando troppo la bolletta della luce o del gas. Uno dei concetti centrali del prodotto è la **pagella**: un giudizio sintetico che confronta la spesa dell'utente con le offerte disponibili sul mercato.

#### Il tuo compito

**Passo 1 — Modella i dati**

Crea due nuovi modelli con le relative migration:

- `Bill` (bolletta): rappresenta una bolletta energetica di un utente. Pensa a quali campi siano rilevanti — almeno il tipo di fornitura (`luce` o `gas`), il consumo in kWh/Smc, l'importo totale pagato e il periodo di riferimento.
- `Offer` (offerta di mercato): rappresenta un'offerta di un fornitore energetico. Campi minimi suggeriti: nome del fornitore, tipo di fornitura, prezzo unitario per kWh/Smc.

Aggiungi anche i relativi seeder con qualche dato di esempio per poter testare il funzionamento.

**Passo 2 — Implementa la logica di confronto**

Crea una classe (service, action, o metodo sul modello — scegli tu la forma più appropriata) che, ricevuta una `Bill`, calcoli:

- l'**offerta più conveniente** tra quelle disponibili dello stesso tipo (luce/gas)
- il **risparmio potenziale** rispetto a quanto l'utente ha effettivamente pagato

**Passo 3 — Esponi in Filament**

- Crea una Resource per `Bill` e una per `Offer`, con form e tabella.
- Nella pagina di dettaglio (o di modifica) di una `Bill`, aggiungi una sezione che mostri il risultato della valutazione: l'offerta più conveniente trovata e il risparmio potenziale. Non preoccuparti di storicizzare il risultato — non è necessario salvarlo in database. Puoi calcolarlo al volo ogni volta che la pagina viene caricata e mostrarlo con un [Infolist](https://filamentphp.com/docs/5.x/infolists/overview), una semplice sezione del form in sola lettura, o anche solo del testo — l'importante è che sia comprensibile a prima vista.

Non esiste una soluzione unica o corretta. Vogliamo capire come modelli un dominio reale, come prendi decisioni di design e come comunichi il risultato all'utente.

**Riferimenti utili:**

- [Filament Infolists](https://filamentphp.com/docs/5.x/infolists/overview)
- [Filament — Sezioni nel form](https://filamentphp.com/docs/5.x/schemas/sections)

---

## Consegna

Una volta completati tutti gli esercizi:

1. Committa tutto su un branch con il tuo nome (es. `feature/mario-rossi`)
2. Apri una Pull Request verso il branch `main` di questa repository

In bocca al lupo dal team Billoo! 🍀

---

Per qualsiasi dubbio o chiarimento: [salvatore.scalzi@billoo.it](mailto:salvatore.scalzi@billoo.it)
