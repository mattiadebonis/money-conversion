# Money Conversion API

## Sommario
- [Funzionalità Principali](#funzionalità-principali)
- [Requisiti](#requisiti)
- [Configurazione](#configurazione)
- [Installazione](#installazione)
- [Avvio con Docker](#avvio-con-docker)
- [Documentazione API](#documentazione-api)
- [Testing](#testing)

## Funzionalità Principali

Questo progetto è un'applicazione API REST sviluppata con **Symfony 6.4** e **API Platform 4.1**. L'applicazione espone delle API per operazioni aritmetiche su valori monetari in formato UK (pounds, shillings e pence).  
Tra le operazioni supportate troviamo somma, sottrazione, moltiplicazione e divisione, con una gestione accurata degli errori (ad esempio, formati non validi, divisione per zero, o sottrazioni con risultato negativo).

### Funzionalità principali

- **Conversione di Valuta:**  
  Converte valori in formato stringa (es. "5p 17s 8d") in pence e viceversa.

- **Operazioni Aritmetiche:**  
  Esegue somma, sottrazione, moltiplicazione e divisione (con eventuale resto) sui valori monetari.

- **Gestione degli Errori:**  
  Gestisce eccezioni personalizzate per formati non validi e operazioni non consentite.

- **API REST:**  
  Le API sono esposte sotto il prefisso `/api`.

- **API di Product e Catalog:**  
  Queste API gestiscono le entità “Product” e “Catalog” con operazioni CRUD disponibili sotto `/api`.

## Requisiti

- **PHP 8.x** (minimo PHP 8.3.11)
- **Composer**

## Dipendenze Composer
Le principali dipendenze del progetto sono:
- symfony/framework-bundle: Il core di Symfony per gestire l’applicazione.
- api-platform/core: Fornisce strumenti per creare API REST e documentazione automatica.
- symfony/security-bundle: Per la gestione dell’autenticazione e della sicurezza.
- symfony/phpunit-bridge: Integrazione di PHPUnit in Symfony.
- phpunit/phpunit: Il framework per i test unitari.
- doctrine/orm: (opzionale) Per la gestione del database tramite ORM.
- symfony/validator: Per la validazione dei dati.
- symfony/maker-bundle: (solo in dev) Per generare codice di base.

## Configurazione

### API Platform
Il file di configurazione `config/packages/api_platform.yaml` definisce:
- Titolo, versione e impostazioni di default (stateless, cache, ecc.).
- Mapping delle risorse, incluse le entità in `src/Entity` e le risorse in `src/ApiResource`.

### Sicurezza
Nel file `config/packages/security.yaml` troviamo:
- Un firewall dedicato per le rotte `/api` con autenticazione (es. JSON login e token).
- Regole di accesso che richiedono il ruolo `ROLE_API` per percorsi `/api`.

## Installazione

1. **Clona il repository**:
   ```bash
   git clone <repository-url>
   cd money-conversion
   ```
2. **Installa le dipendenze**:
   ```bash
   composer install
   ```
3. Se necessario, installa manualmente le dipendenze:
   

## Avvio con Docker
1. Esegui `docker-compose build` per costruire le immagini.
2. Esegui `docker-compose up -d` per avviare i container in background.
3. Accedi all’app su http://localhost:8001 o la porta configurata in `docker-compose.yml`.

## Documentazione API

Documentazione API - Money Conversion

Questa documentazione descrive gli endpoint disponibili per le operazioni aritmetiche sui valori monetari in formato UK (Xp Ys Zd), la gestione dei prodotti e la gestione dei cataloghi.

Operazioni disponibili (Money Conversion)

1. Somma di due valori monetari

Endpoint: POST /money/addition

Descrizione: Esegue la somma di due valori monetari.

Esempio: 5p 17s 8d + 3p 4s 10d = 9p 2s 6d

Body della richiesta:

{
    "first": "5p 17s 8d",
    "second": "3p 4s 10d"
}

2. Sottrazione di due valori monetari

Endpoint: POST /money/subtraction

Descrizione: Esegue la sottrazione di due valori monetari.

Esempio: 5p 17s 8d - 3p 4s 10d = 2p 12s 10d

Body della richiesta:

{
    "first": "5p 17s 8d",
    "second": "3p 4s 10d"
}

3. Moltiplicazione di un valore monetario per un intero

Endpoint: POST /money/multiplication

Descrizione: Moltiplica un valore monetario per un numero intero.

Esempio: 5p 17s 8d * 2 = 11p 15s 4d

Body della richiesta:

{
    "value": "5p 17s 8d",
    "multiplier": 2
}

4. Divisione di un valore monetario

Endpoint: POST /money/division

Descrizione: Divisione resto (da indicare tra parentesi) con un intero (no decimali).

Esempio: 18p 16s 1d / 15 = 1p 5s 0d (1s 1d)

Body della richiesta:

{
    "value": "18p 16s 1d",
    "divisor": 15
}

Operazioni disponibili (Product Management)

1. Recupera la lista di tutti i prodotti

Endpoint: GET /products

Descrizione: Restituisce un array di prodotti, ciascuno con id, nome, costo e il catalogo associato (se presente).

2. Crea un nuovo prodotto

Endpoint: POST /products

Descrizione: Crea un prodotto specificando nome, costo e l'IRI del catalogo associato (es. "/api/catalogs/1").

Body della richiesta:

{
    "nome": "Prodotto A",
    "costo": 99.99,
    "catalog": "/api/catalogs/1"
}

3. Recupera un prodotto

Endpoint: GET /products/{id}

Descrizione: Restituisce il prodotto identificato dall'id (identificatore univoco).

4. Aggiorna completamente un prodotto

Endpoint: PUT /products/{id}

Descrizione: Aggiorna completamente un prodotto. È necessario inviare tutti i campi (nome, costo, catalog).

Body della richiesta:

{
    "nome": "Prodotto Aggiornato",
    "costo": 89.99,
    "catalog": "/api/catalogs/2"
}

5. Aggiornamento parziale di un prodotto

Endpoint: PATCH /products/{id}

Descrizione: Aggiorna uno o più campi del prodotto. Utile per rimuovere l'associazione con un catalogo (inviando 'catalog': null) oppure assegnarne uno nuovo. Imposta il Content-Type a 'application/merge-patch+json' o 'application/json'.

Body della richiesta:

{
    "catalog": null
}

6. Elimina un prodotto

Endpoint: DELETE /products/{id}

Descrizione: Elimina definitivamente il prodotto identificato dall'id.

Operazioni disponibili (Catalog Management)

1. Recupera la lista dei cataloghi

Endpoint: GET /catalogs

Descrizione: Restituisce un array di cataloghi con id, nome e i prodotti associati.

2. Crea un nuovo catalogo

Endpoint: POST /catalogs

Descrizione: Crea un catalogo specificando il nome. Restituisce il catalogo creato con il relativo id.

Body della richiesta:

{
    "nome": "Catalogo A"
}

3. Recupera un catalogo specifico

Endpoint: GET /catalogs/{id}

Descrizione: Restituisce il catalogo identificato dall'id, inclusi i prodotti associati.

4. Aggiorna un catalogo

Endpoint: PUT /catalogs/{id}

Descrizione: Aggiorna i dati del catalogo specificato.

Body della richiesta:

{
    "nome": "Catalogo Aggiornato"
}

5. Elimina un catalogo

Endpoint: DELETE /catalogs/{id}

Descrizione: Elimina definitivamente il catalogo identificato dall'id.

## Testing

Autenticazione

Se gli endpoint richiedono autenticazione tramite header X-API-TOKEN, aggiungere:

X-API-TOKEN: your-token

nell'header della richiesta HTTP.

Testing

Per eseguire i test automatici:

symfony test