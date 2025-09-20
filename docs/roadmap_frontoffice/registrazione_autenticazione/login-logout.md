# Login/Logout

## Descrizione
Sistema di autenticazione con gestione accessi differenziati per pazienti, odontoiatri e admin.

## Stato Attuale
- **Completamento**: 100%
- **Responsabile**: Team Backend
- **Data completamento**: Marzo 2025

## Funzionalità Implementate
- Login con email e password
- Logout su tutti i dispositivi
- Remember me per sessioni persistenti
- Tracciamento tentativi falliti
- Protezione CSRF
- Blocco account dopo tentativi falliti
- Log attività di accesso

## Tecnologie Utilizzate
- Laravel Fortify per autenticazione base
- Session Storage personalizzato
- Rate limiting per protezione
- Middleware customizzati per ruoli

## Sicurezza
- Rate limiting per prevenzione brute force
- Auditing accessi
- Rotazione token
- Validazione IP (opzionale)

## Test e Qualità
- Test unitari: 18 test
- Test funzionali: 12 test
- Security audit completato

## Documentazione Correlata
- [Registrazione Pazienti](./registrazione-pazienti.md)
- [Recupero Password](./recupero-password.md)
- [Autenticazione a due fattori](./2fa.md)
- [Verifica Email](./verifica-email.md)

## Riferimento Principale
→ [Torna a Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
