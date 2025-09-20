# Sistema Notifiche

## Descrizione Funzionalità
Implementazione di un sistema di notifiche multi-canale per paziente e odontoiatra, con supporto per email, SMS, notifiche push e integrazione calendario.

## Stato Attuale
- **Completamento**: 70%
- **Responsabile**: Team Backend
- **Deadline**: Luglio 2025
- **Priorità**: Media
- **Dipendenze**: Sistema prenotazioni, Modelli email/SMS

## Mockup e Wireframe
I mockup dettagliati sono disponibili nella cartella `/docs/images/`:
- Centro notifiche: [Centro notifiche](/docs/images/25.png)
- Preferenze notifiche: [Preferenze](/docs/images/26.png)

## Requisiti Tecnici

### Canali di Notifica
- Email (implementato)
- SMS (in corso)
- Push browser (in corso)
- In-app notifications (implementato)
- Download iCal/Google Calendar (pianificato)

### Tipi di Notifica
- Conferma prenotazione
- Promemoria appuntamento (24h, 1h prima)
- Modifica/cancellazione appuntamento
- Documenti richiesti
- Referto disponibile
- Aggiornamento stato rimborso

## Implementazione Tecnica

### Backend
```php
namespace Modules\SaluteOra\app\Notifications;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected Appointment $appointment;
    
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function via($notifiable): array
    {
        return $notifiable->preferredChannels();
    }
    
    public function toMail($notifiable): MailMessage
    {
        // Template email promemoria
    }
    
    public function toSms($notifiable): array
    {
        // Template SMS promemoria
    }
    
    public function toBrowser($notifiable): array
    {
        // Template notifica browser
    }
}
```

### Frontend
```php
namespace Modules\SaluteOra\Filament\Pages;

class NotificationPreferences extends XotBasePage
{
    // Implementazione pagina preferenze notifiche
    // con canali, frequenza e disattivazione
}
```

## Timeline di Sviluppo

| Fase | Descrizione | Data Inizio | Data Fine | Stato |
|------|------------|-------------|-----------|-------|
| 1 | Sistema base email e in-app | 01-04-2025 | 30-04-2025 | Completato |
| 2 | Integrazione SMS | 01-06-2025 | 20-06-2025 | In corso |
| 3 | Notifiche push browser | 15-06-2025 | 10-07-2025 | In corso |
| 4 | Preferenze e personalizzazione | 20-06-2025 | 15-07-2025 | Pianificato |
| 5 | Integrazione calendario | 01-07-2025 | 20-07-2025 | Pianificato |

## Servizi Esterni
- SMS: Twilio API (implementazione in corso)
- Push: Firebase Cloud Messaging (implementazione in corso)
- Calendario: iCal/Google Calendar API (pianificato)

## Gestione Preferenze Utente
Ciascun utente (paziente e odontoiatra) potrà personalizzare:
- Canali preferiti per ciascun tipo di notifica
- Frequenza dei promemoria
- Disattivazione selettiva notifiche
- Orari di non disturbo

## Testing e Validazione
- Test di consegna per tutti i canali
- Verifica timing dei promemoria
- Test di carico per invii massivi
- Verifica gestione errori e retry

## Integrazione con Altri Moduli
- Sistema prenotazioni: [patient-book.md](patient-book.md)
- Area paziente: [area-paziente.md](area-paziente.md)
- Sistema rimborsi: [sistema-rimborsi.md](sistema-rimborsi.md)

## KPI e Metriche
- Tasso di consegna notifiche > 99%
- Riduzione no-show appuntamenti del 50%
- Tasso di apertura email > 60%
- Tempo di consegna SMS < 30 secondi

## Monitoraggio e Analytics
Il sistema include dashboard per monitorare:
- Tasso di consegna per canale
- Tasso di apertura/click
- Effetto delle notifiche sui no-show
- Preferenze utenti per ottimizzazioni future

## Collegamenti
- [Documentazione API notifiche](../standards/notification-api.md)
- [Template notifiche](../standards/notification-templates.md)
- [Privacy e GDPR](../standards/privacy-gdpr.md)
