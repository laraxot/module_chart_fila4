# Regole Fondamentali del Progetto

## Estensioni e Classi Base

### Filament Resources
- ❌ NON estendere mai direttamente le classi di Filament
- ✅ SEMPRE estendere le classi base Xot con prefisso `XotBase`
- Esempio:
  ```php
  // ❌ NON FARE
  class DoctorRegistrationResource extends Resource
  
  // ✅ FARE
  class DoctorRegistrationResource extends XotBaseResource
  ```

### Componenti Filament
- Le classi che estendono `XotBaseResource` NON devono implementare:
  - `form()`
  - `table()`
  - Questi metodi sono già implementati nelle classi base

## Traduzioni
- ❌ NON usare il metodo `label()`
- ✅ Usare i file di traduzione tramite `LangServiceProvider`
- Esempio:
  ```php
  // ❌ NON FARE
  ->label('Nome')
  
  // ✅ FARE
  ->label(__('dentist.fields.name'))
  ```

## Notifiche
- ❌ NON creare nuove classi di notifica per ogni caso
- ✅ Usare `RecordNotification` direttamente
- Esempio:
  ```php
  // ❌ NON FARE
  class DentistRegistrationNotification extends Notification
  
  // ✅ FARE
  $notification = new RecordNotification($record, 'dentist.registration');
  ```

## Enums
- ❌ NON creare enum specifici per ogni modulo se possono essere riutilizzati
- ✅ Usare enum generici quando possibile
- Esempio:
  ```php
  // ❌ NON FARE
  enum DentistRegistrationStatus
  
  // ✅ FARE
  enum RegistrationStatus
  ```

## Actions
- ❌ NON usare Services
- ✅ Usare Spatie/Laravel-Queueable-Action
- Esempio:
  ```php
  // ❌ NON FARE
  class CreateDentistService
  
  // ✅ FARE
  class CreateDentistAction implements QueueableAction
  ```

## Documentazione
- ❌ NON creare documentazione duplicata
- ✅ Mantenere la documentazione nel modulo corretto
- Esempio:
  ```php
  // ❌ NON FARE
  /docs/lang-service-provider-improvements.md
  
  // ✅ FARE
  /laravel/Modules/Lang/docs/lang-service-provider-improvements.md
  ```

## Collegamenti
- [Modulo Xot](../laravel/Modules/Xot/README.md)
- [Best Practices](./best-practices.md)
- [Guida Contribuzione](./CONTRIBUTING.md)

## Note
- Questo file serve come riferimento rapido per evitare errori comuni
- Aggiornare questo file quando vengono aggiunte nuove regole
- Consultare questo file prima di ogni implementazione 
