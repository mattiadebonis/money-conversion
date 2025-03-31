# Money Conversion API

Questo progetto è un'applicazione API REST sviluppata con **Symfony 6.4** e **API Platform 4.1**. L'applicazione espone delle API per operazioni aritmetiche su valori monetari in formato UK (pounds, shillings e pence).  
Tra le operazioni supportate troviamo somma, sottrazione, moltiplicazione e divisione, con una gestione accurata degli errori (ad esempio, formati non validi, divisione per zero, o sottrazioni con risultato negativo).

## Funzionalità principali

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