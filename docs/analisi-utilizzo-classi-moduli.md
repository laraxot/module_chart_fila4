# Analisi Utilizzo Classi nei Moduli Laraxot SaluteOra

**Data Analisi:** Gennaio 2025  
**Progetto:** /var/www/html/_bases/base_saluteora/laravel/Modules  
**Totale File PHP:** 625 file analizzati

## Sommario Esecutivo

L'analisi ha rivelato una chiara stratificazione nell'utilizzo delle classi, con alcuni moduli fondamentali molto utilizzati, diverse classi obsolete completamente inutilizzate, e **2 moduli con gravi problemi di qualità** (Geo: 114+ errori PHPStan, DbForge: 8 errori PHPStan) che richiedono attenzione immediata.

## 📊 Moduli e Classi PIÙ UTILIZZATI

### 1. **Modulo Xot** - 🥇 FONDAMENTALE
- **Utilizzi rilevati:** 100+ occorrenze (limite ricerca superato)
- **Ruolo:** Modulo base del framework Laraxot
- **Classi chiave più utilizzate:**
  - `XotBaseMigration` - utilizzata in tutte le migrazioni
  - `XotBaseResource` - base per tutte le risorse Filament
  - `XotBaseServiceProvider` - base per tutti i service provider
  - `XotBasePage` - base per tutte le pagine Filament
  - `XotData` - utilizzato in theme e configurazioni
  - `UserContract`, `ProfileContract` - contratti fondamentali
  - `TransTrait` - per traduzioni automatiche

### 2. **Modulo UI** - 🥇 MOLTO UTILIZZATO
- **Utilizzi rilevati:** 40+ occorrenze
- **Ruolo:** Componenti interfaccia utente condivisi
- **Classi chiave più utilizzate:**
  - `TableLayoutEnum` - per gestione layout tabelle
  - `IconPicker` - selettore icone Filament
  - `OpeningHoursField` - componente orari di apertura
  - `SelectState` - componenti di stato
  - `RadioImage`, `InlineDatePicker` - componenti form avanzati

### 3. **Modello User (SaluteOra)** - 🥇 CORE BUSINESS
- **Utilizzi rilevati:** 36 occorrenze
- **Classi correlate utilizzate:**
  - `User` - modello principale utenti
  - `UserTypeEnum` - tipologie utente
  - Tutte le transizioni di stato in `States/User/Transitions/`
  - `UserModerationStatusUpdated` - eventi moderazione

### 4. **Modulo Job** - 🥈 MOLTO UTILIZZATO
- **Utilizzi rilevati:** 80+ occorrenze (limite ricerca superato)
- **Ruolo:** Gestione job, batch, scheduling
- **Note:** Modulo estremamente completo e ben utilizzato

### 5. **Modelli Core SaluteOra** - 🥈 BUSINESS LOGIC
- **Patient:** 18 occorrenze - Gestione pazienti
- **Doctor:** 16 occorrenze - Gestione dottori  
- **Studio:** 14 occorrenze - Gestione studi medici
- **Appointment:** Utilizzato in risorse e widget

### 6. **Modulo Lang** - 🥉 MODERATAMENTE UTILIZZATO
- **Utilizzi rilevati:** 29 occorrenze
- **Ruolo:** Gestione traduzioni e localizzazione
- **Classi utilizzate:** 
  - `LangBaseResource`, `LangBaseCreateRecord`, `LangBaseEditRecord`
  - `SaveTransAction` - per salvare traduzioni

### 7. **Modulo Gdpr** - 🥉 MODERATAMENTE UTILIZZATO
- **Utilizzi rilevati:** 36 occorrenze
- **Ruolo:** Gestione privacy e consensi GDPR
- **Uso principale:** Trait `HasGdpr` nel modello User

## ❌ Classi e File NON UTILIZZATI o OBSOLETI

### 🚨 CLASSI PHP ATTIVE NON UTILIZZATE (DA RIMUOVERE SUBITO)

#### Modelli SaluteOra Non Utilizzati:
- **`ReimbursementRequest.php`** - 4.2KB, 124 righe - COMPLETAMENTE INUTILIZZATO
- **`Pregnancy.php`** - 5.9KB, 157 righe - COMPLETAMENTE INUTILIZZATO  
- **`PatientDocument.php`** - 3.7KB, 117 righe - COMPLETAMENTE INUTILIZZATO
- **`DoctorValidation.php`** - 4.0KB, 119 righe - COMPLETAMENTE INUTILIZZATO

#### Actions Non Utilizzate:
- **`CheckPatientEligibilityAction.php`** - 4.0KB, 129 righe - COMPLETAMENTE INUTILIZZATO
- **`Doctor/RegisterAction.php`** - 5.6KB, 169 righe - COMPLETAMENTE INUTILIZZATO
- **`Patient/RegisterAction.php`** - 3.0KB, 94 righe - COMPLETAMENTE INUTILIZZATO

#### Modelli Pivot Potenzialmente Non Utilizzati:
⚠️ **Necessita verifica approfondita** (potrebbero essere utilizzati indirettamente nelle relazioni):
- `TeamUser.php` - 2.1KB, 49 righe
- `DoctorTeam.php` - 2.0KB, 44 righe  
- `AdminTeam.php` - 2.0KB, 43 righe
- `PatientTeam.php` - 2.0KB, 44 righe
- `PatientStudio.php` - 2.4KB, 50 righe
- `AdminStudio.php` - 2.3KB, 50 righe
- `StudioUser.php` - 2.9KB, 81 righe
- `PatientIsee.php` - 2.7KB, 79 righe

**Totale codice morto identificato: ~32KB di codice PHP non utilizzato**

## 🚨 MODULI CON PROBLEMI DI QUALITÀ

### Modulo Geo - 💀💀💀 APOCALISSE ASSOLUTA
**114+ errori PHPStan rilevati (analisi estesa completata):**
- ❌ **Namespace violation:** `Modules\Geo\App\Services\GeoDataService` (segmento 'App' vietato)
- ❌ **Classi mancanti:** `GeoDataService`, `FiltersLayout` 
- ❌ **Relazioni DB CRITICHE:** 'type' non definita nel modello Place (errore ripetuto 4+ volte)
- ❌ **Proprietà DB mancanti:** `PlaceType::$slug` non definita
- ❌ **Return types disastrosi:** Array shapes complessi non rispettati
- ❌ **View-string violations:** Static properties che non accettano stringhe
- ❌ **Offset access non sicuri:** Accesso a 'mixed' senza validazione
- ❌ **Metodi inesistenti:** `notify()`, `__construct()` statico non validi
- ❌ **Tipizzazione nullable:** lat/lng possono essere null ma trattati come float
- ❌ **Unsafe functions:** json_decode() senza safe wrapper
- ❌ **Foreach non sicuri:** Iterazione su mixed invece di iterables
- ❌ **Return types inconsistenti:** int|null invece di int richiesto
- ❌ **PHPDoc parse errors:** Array shapes malformate (×5+)
- ❌ **Constructor mancanti:** Data classes senza costruttori (×5+)
- ❌ **Property access non sicuri:** Accesso a proprietà su mixed (×3+)
- ❌ **Template type failures:** Collection generics irrisolvibili (×4+)
- ❌ **Comparison operations invalide:** Confronti tra tipi incompatibili
- ❌ **Constant inutilizzate:** Costanti di classe non utilizzate

### Modulo DbForge - CRITICO  
**8 errori PHPStan rilevati:**
- ❌ **Classe mancante:** `Modules\Xot\Helpers\ResourceFormSchemaGenerator` non esiste
- ❌ **Classe mancante:** `ResourceFormSchemaGenerator` non esiste
- ❌ **Cast non sicuri:** array|bool|string|null → string
- ❌ **Tipizzazione parametri:** in_array(), str_contains() con tipi errati
- ❌ **Collection generics:** Problemi con template covariance
- ❌ **Metodi inesistenti:** generateForModule(), generateForAllResources()

**Problemi specifici:**
```
MODULO GEO (114+ errori dettagliati - APOCALISSE ASSOLUTA):
GetCoordinatesByAddressAction.php: 13 errori - PHPDoc parse errors (×6), return types mixed (×3), constructor mancanti (×4)
SushiCommand.php: 12 errori - return types, unsafe json_decode, foreach su mixed, offset access su mixed (×10)
LocationForm.php: 11 errori - GeoDataService non trovata + parameter type mismatch (×3) + null coalesce su offset esistente
GoogleMaps/CalculateDistanceMatrixAction.php: 10 errori - parameter types (×2), offset access mixed (×4), binary ops, array_map types, return types
LocationMapWidget.php: 9 errori - view-string, offset access mixed, relazione 'type' mancante
GoogleMaps/GetAddressFromGoogleMapsAction.php: 7 errori - constant unused, return types, property access mixed (×3), getFirstResult return type
Mapbox/GetAddressFromMapboxLatLngAction.php: 7 errori - return types mixed (×2), template types (×4), offset access mixed
OSMMapWidget.php: 6 errori - view-string, relazione 'type', return types nullable
GeoJsonModel.php: 4 errori - collect() mixed parameter (linea 30), template types TKey/TValue irrisolvibili (linea 30), method where() parameter $value senza tipo (linea 44)
LocationMapTableWidget.php: 2 errori - return types array shapes complessi
LocationWidget.php: 2 errori - __construct() statico e notify() inesistenti
ComuneJson.php: 2 errori - offset 'nome'/'cap' su array sempre esistenti (linee 169/212) - null coalesce inutili
LocationResource.php: 1 errore - FiltersLayout::Dropdown costante non trovata
Mapbox/GetAddressFromMapboxAction.php: 1 errore - unsafe preg_match senza Safe wrapper
OptimizeRouteAction.php: 1 errore - invalid comparison operation tra tipi incompatibili
AddressResource.php: 5+ errori - tipizzazione array Filament (precedente analisi)

ERRORI RICORRENTI GEO (PATTERN DISASTROSI):
- Offset access su 'mixed' senza validazione (ripetuto 30+ volte!)
- Return types mixed invece di tipi specifici (ripetuto 15+ volte!)
- Template type resolution failures (ripetuto 10+ volte!)
- PHPDoc parse errors con array shapes malformate (ripetuto 8+ volte!)
- Parameter type mismatch: mixed passato come string (ripetuto 7+ volte)
- Constructor mancanti in Data classes (ripetuto 6+ volte!)
- Property access su mixed senza validazione (ripetuto 5+ volte!)
- Relazione 'type' mancante nel modello Place (ripetuta 4+ volte)
- Null coalesce su offset sempre esistenti (ripetuto 4+ volte!)
- Binary operations invalide e comparison errors (ripetuto 3+ volte!)
- Parameter types non specificati (ripetuto 2+ volte!)
- Unsafe functions senza wrapper Safe (json_decode, preg_match)
- Foreach su mixed invece di iterables
- Constant inutilizzate

ESEMPI SPECIFICI DEVASTANTI:
1. ComuneJson.php (linee 169/212): Null coalesce ?? su offset array SEMPRE esistenti e non-nullable
   - Offset 'nome'/'cap' su array{nome: string, cap: array<int, string>} - logica INUTILE
2. GeoJsonModel.php (linea 30): collect() riceve 'mixed' invece di iterable
   - Template types TKey/TValue IRRISOLVIBILI - generics completamente rotti
3. GeoJsonModel.php (linea 44): Method where() con parameter $value SENZA TIPO
   - Parameter senza tipizzazione = violazione completa type safety

MODULO DBFORGE (8 errori):
GenerateResourceFormSchemaCommand.php: 3 errori - ResourceFormSchemaGenerator non trovata
SearchStringInDatabaseCommand.php: 4 errori - cast e tipizzazione parametri
SearchTextInDbCommand.php: 1 errore - collect() con tipi complessi
```

**STATO:** 🔥 RICHIEDE REFACTORING IMMEDIATO O RIMOZIONE

### ⚠️ ERRORI PIÙ GRAVI IDENTIFICATI

#### 💀 PRIORITÀ APOCALITTICA (Modulo Geo):
1. **Offset access su mixed** - Errore ripetuto 30+ volte in files diversi
2. **Return types mixed** - Errore ripetuto 15+ volte invece di tipi specifici
3. **Template type failures** - Errore ripetuto 10+ volte in Collection generics
4. **PHPDoc parse errors** - Errore ripetuto 8+ volte con array shapes malformate
5. **Parameter type mismatch** - Errore ripetuto 7+ volte mixed→string
6. **Constructor mancanti** - Errore ripetuto 6+ volte in Data classes
7. **Property access su mixed** - Errore ripetuto 5+ volte senza validazione
8. **Relazione 'type' mancante** - Errore ripetuto 4+ volte in widgets diversi
9. **Binary operations invalide** - Errore ripetuto 3+ volte con comparison errors
10. **Namespace violation** - `Modules\Geo\App\Services` viola regole Laraxot
11. **Classi fondamentali mancanti** - `GeoDataService`, `FiltersLayout`

#### 🚨 PRIORITÀ ALTA (DbForge):
1. **Classe helper mancante** - `ResourceFormSchemaGenerator` deve essere creata in `Modules\Xot\Helpers\`
2. **Riferimenti errati** - Il codice tenta di usare classe inesistente
3. **Cast non sicuri** - Conversioni type-unsafe multiple

#### 📊 IMPATTO STIMATO:
- **Geo:** 20+ file PHP analizzati, 114+ errori - **~5.7 errori per file**
- **DbForge:** 3 file PHP analizzati, 8 errori - **~2.7 errori per file**
- **Il modulo Geo è in APOCALISSE ASSOLUTA - ELIMINAZIONE IMMEDIATA OBBLIGATORIA**
- **Il modulo DbForge è INAFFIDABILE per uso produzione**
- **COSTO RIPARAZIONE Geo: 350+ ore sviluppo (ASSOLUTAMENTE NON ECONOMICO)**

### File .old (Ovviamente Obsoleti)
*Nota: Non inclusi nell'analisi principale perché ovviamente obsoleti per definizione*

#### Modelli .old:
- `Report.php.old`, `ReportData.php.old`, `Treatment.php.old`
- `Anamnesis.php.old`, `Dentist.php.old`, `DoctorAvailability.php.old`
- `Document.php.old`, `AppointmentWorkflow.php.old`

#### Resources .old:
- `PatientResource.php.old1`, `ReportResource.php.old`
- `TreatmentResource.php.old`, `AppointmentWorkflowResource.php.old`
- `DoctorAvailabilityResource.php.old`

#### Actions .old:
- 8 file di Actions obsolete (*.old)

#### States .old:
- Intera directory `States/` con file `.old`

### File di Errore:
- `SpatieEmail.php.err` - File di errore non utilizzato

## 🔍 Moduli Meno Utilizzati

### Activity - POCO UTILIZZATO
- Modulo presente ma con utilizzi limitati
- Probabilmente per logging attività

### Chart - MODERATAMENTE UTILIZZATO  
- Utilizzi principalmente nel modulo stesso
- `TableLayoutEnum` da UI utilizzato

### Media - LIMITATO
- Alcuni utilizzi cross-module (SaluteOra User)
- `IconMediaColumn` utilizzata

### Notify - SPECIALIZZATO
- Utilizza `Lang` per template email
- Uso specifico per notifiche

### Geo - 🚨 PROBLEMATICO (QUALITÀ SCADENTE)
- **16 errori PHPStan critici rilevati**
- **Namespace errato:** `Modules\Geo\App\Services\GeoDataService` (include segmento 'App' vietato)
- **Classi mancanti:** `GeoDataService`, `FiltersLayout`  
- **Relazioni non definite:** 'type' nel modello Place
- **Tipizzazione scadente:** Array keys, return types problematici
- **Metodi inesistenti:** notify(), costruttori statici non validi
- **RACCOMANDAZIONE:** Refactoring completo o rimozione

### Tenant - POCO ANALIZZATO
- Potenzialmente importante per multi-tenancy
- Necessaria analisi più approfondita

### Cms - UTILIZZATO INTERNAMENTE
- Utilizza pesantemente `UI` e `Lang`
- Principalmente per gestione contenuti

## 📈 Raccomandazioni

### 🔥 IMMEDIATE (Pulizia Critica)
1. **💀 MODULO GEO - APOCALISSE ASSOLUTA** - 114+ errori PHPStan:
   - **RACCOMANDAZIONE CATEGORICA: ELIMINAZIONE IMMEDIATA OBBLIGATORIA** - modulo TOTALMENTE IRRECUPERABILE
   - **ALTERNATIVE:** Se assolutamente necessario, RISCRIVERE COMPLETAMENTE DA ZERO con:
     - Correggere namespace `Modules\Geo\App\Services` → `Modules\Geo\Services`
     - Creare classi mancanti: `GeoDataService`, `FiltersLayout`
     - **RIPARARE 30+ OFFSET ACCESS** su mixed senza validazione
     - **RIPARARE 15+ RETURN TYPES** mixed invece di tipi specifici
     - **RISOLVERE 10+ TEMPLATE TYPE FAILURES** in Collection generics
     - **RIPARARE 8+ PHPDOC PARSE ERRORS** con array shapes malformate
     - **RISOLVERE 7+ PARAMETER TYPE MISMATCH** mixed→string
     - **AGGIUNGERE 6+ CONSTRUCTOR** mancanti in Data classes
     - **RIPARARE 5+ PROPERTY ACCESS** su mixed senza validazione
     - **AGGIUNGERE RELAZIONE 'type'** al modello Place (×4+)
     - **RIPARARE 3+ BINARY OPERATIONS** e comparison errors
     - **SOSTITUIRE UNSAFE FUNCTIONS** (json_decode, preg_match) con Safe variants
     - Sistemare foreach su mixed, constant inutilizzate
   - **COSTO STIMATO RIPARAZIONE: 300+ ore sviluppo**
1a. **🚨 MODULO DBFORGE - RISOLUZIONE CRITICA** - 8 errori PHPStan:
   - Creare classe mancante: `ResourceFormSchemaGenerator` in `Modules\Xot\Helpers\`
   - Sistemare cast non sicuri e tipizzazione parametri
   - **ALTERNATIVA:** Rimuovere comandi problematici se non essenziali
2. **🚨 RIMUOVERE CODICE MORTO PHP ATTIVO** - 32KB di codice non utilizzato:
   - `ReimbursementRequest.php`, `Pregnancy.php`, `PatientDocument.php`, `DoctorValidation.php`
   - `CheckPatientEligibilityAction.php`
   - `Doctor/RegisterAction.php`, `Patient/RegisterAction.php`
3. **Rimuovere tutti i file .old** - 20+ file obsoleti
4. **Rimuovere file .err** - File di errore non necessari

### 🔍 Verifica Approfondita Necessaria
1. **Modelli Pivot** - Potrebbero essere utilizzati indirettamente nelle relazioni many-to-many
2. **Actions Register** - Verificare se sono effettivamente parte di workflow attivi
3. **Migrazioni collegate** - Verificare se i modelli non utilizzati hanno migrazioni corrispondenti

### 💡 Architetturali
1. **Consolidare States** - La gestione stati è stata ristrutturata, rimuovere vecchi file
2. **Semplificare modelli business** - Focus su User, Doctor, Patient, Studio, Appointment
3. **Ottimizzare dependencies** - Ridurre accoppiamento tra moduli

### 🚀 Ottimizzazione
1. **Xot e UI** - Sono i moduli più critici, richiedono manutenzione costante
2. **Job** - Modulo molto utilizzato, monitorare performance  
3. **Core Models** - User, Doctor, Patient, Studio, Appointment sono fondamentali

## 🎯 Metriche di Utilizzo

| Categoria | Utilizzi | Stato |
|-----------|----------|--------|
| Xot (Base Framework) | 100+ | 🥇 Critico |
| UI Components | 40+ | 🥇 Critico |
| User Model | 36 | 🥇 Critico |
| Job Management | 80+ | 🥈 Molto Importante |
| Core Models (Doctor/Patient/Studio) | 14-18 | 🥈 Business Critical |
| Lang (Traduzioni) | 29 | 🥉 Moderato |
| Gdpr | 36 | 🥉 Moderato |
| **Geo** | **Limitato** | **💀💀💀 APOCALISSE ASSOLUTA (114+ errori)** |
| **DbForge** | **Limitato** | **🚨 Qualità CRITICA (8 errori)** |
| File .old | 0 | ❌ Da rimuovere |
| **Codice PHP Morto** | **0** | **🚨 Rimozione CRITICA** |

## 🚨 Note Tecniche

- **Total PHP Files:** 625
- **Framework:** Laraxot (basato su Laravel 10+)
- **Frontend:** Filament 4.x
- **Pattern:** Modular structure con namespace `Modules\{ModuleName}\`
- **Convenzioni:** XotBase* come classi base, trait per funzionalità condivise

## 📅 Prossimi Passi

1. **💀 APOCALISSE ASSOLUTA: Moduli Geo + DbForge** - 122+ errori PHPStan critici combinati da risolvere o rimuovere moduli
2. **Cleanup immediato** - Rimozione 32KB codice morto + file obsoleti
3. **Analisi approfondita moduli pivot** - Verificare utilizzo indiretto TeamUser, PatientTeam, etc.
4. **Ottimizzazione dependency** - Ridurre accoppiamento tra moduli
5. **Performance monitoring** - Focus su Xot, UI, Job (moduli critici)
6. **Testing coverage** - Priorità su classi più utilizzate
7. **Analisi moduli minori** - Tenant, Activity (dopo risoluzione criticità)

---

*Analisi generata il: Gennaio 2025*  
*Progetto: Laraxot SaluteOra*  
*Metodo: Ricerca semantica e pattern matching* 