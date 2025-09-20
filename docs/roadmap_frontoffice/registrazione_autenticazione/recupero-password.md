# Recupero Password

## Descrizione
Sistema sicuro per il recupero password con token temporanei e notifiche multiple.

## Stato Attuale
- **Completamento**: 100%
- **Responsabile**: Team Backend
- **Data completamento**: Marzo 2025

## Funzionalità Implementate
- Generazione token sicuri con scadenza
- Invio email con link di reset
- Form di reset con validazione password
- Sistema anti-bruteforce
- Tracciamento tentativi di recupero
- Notifica di avvenuto cambio password

## Processo di Recupero
1. Utente richiede reset tramite form dedicato
2. Sistema verifica email e genera token univoco
3. Email inviata con link sicuro
4. Link apre form di reset
5. Nuova password validata e salvata
6. Notifica di conferma inviata
7. Tutti i token precedenti invalidati

## Sicurezza
- Token con scadenza a 30 minuti
- Hash token SHA-256 in database
- Rate limiting per prevenzione abusi
- IP tracking per richieste sospette
- Notifica di sicurezza per cambio effettuato

## Test e Qualità
- Test unitari: 15 test
- Test funzionali: 8 test
- Security audit completato

## Documentazione Correlata
- [Login/Logout](./login-logout.md)
- [Registrazione Pazienti](./registrazione-pazienti.md)
- [Verifica Email](./verifica-email.md)

## Riferimento Principale
→ [Torna a Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
