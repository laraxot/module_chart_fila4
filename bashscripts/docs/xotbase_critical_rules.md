# 🚨 REGOLA CRITICA XOTBASE - MAI DIMENTICARE

## Regola Fondamentale Laraxot/PTVX

**NON estendere MAI classi Filament direttamente. SEMPRE usare le classi XotBase.**

## ❌ VIETATO - Non fare mai questo:

```php
// ❌ SBAGLIATO - Mai estendere direttamente Filament
class Dashboard extends Filament\Pages\Dashboard
class MyResource extends Filament\Resources\Resource
class MyWidget extends Filament\Widgets\Widget
class MyPage extends Filament\Pages\Page
```

## ✅ OBBLIGATORIO - Fare sempre questo:

```php
// ✅ CORRETTO - Sempre estendere XotBase
class Dashboard extends Modules\Xot\Filament\Pages\XotBaseDashboard
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
class MyWidget extends Modules\Xot\Filament\Widgets\XotBaseWidget
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

## Perché questa regola è CRITICA

### 1. **Architettura Laraxot/PTVX**
- Tutti i moduli devono seguire lo stesso pattern
- Le classi XotBase forniscono configurazioni automatiche
- Garantiscono coerenza tra tutti i moduli

### 2. **Configurazione Automatica**
- XotBase* gestisce automaticamente:
  - Namespace del modulo
  - Path di amministrazione
  - Configurazioni Filament
  - Integrazione con il sistema

### 3. **Manutenibilità**
- Cambiamenti centralizzati in XotBase
- Pattern uniformi in tutto il sistema
- Debugging semplificato

## Classi XotBase Disponibili

### Pages
- `XotBaseDashboard` - Dashboard standard
- `XotBasePage` - Pagine generiche

### Resources
- `XotBaseResource` - Risorse standard
- `XotBaseListResource` - Liste
- `XotBaseFormResource` - Form

### Widgets
- `XotBaseWidget` - Widget generici
- `XotBaseChartWidget` - Grafici
- `XotBaseStatsWidget` - Statistiche

### Providers
- `XotBasePanelProvider` - Provider pannelli
- `XotBaseServiceProvider` - Service provider

## Pattern di Implementazione

### 1. Dashboard
```php
<?php
declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = '{modulename}::filament.pages.dashboard';
}
```

### 2. Resource
```php
<?php
declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
}
```

### 3. Widget
```php
<?php
declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyWidget extends XotBaseWidget
{
    protected static string $view = '{modulename}::filament.widgets.my-widget';
}
```

## Verifica Automatica

### Controllo Pre-Implementazione
Prima di creare qualsiasi classe Filament, verificare sempre:

1. **Esiste una classe XotBase corrispondente?**
   ```bash
   # Cercare in Modules\Xot\Filament\
   find laravel/Modules/Xot/app/Filament -name "XotBase*.php"
   ```

2. **Qual è il pattern corretto?**
   - Studiare altri moduli esistenti
   - Controllare la documentazione
   - Verificare le best practices

3. **La classe estende XotBase?**
   ```php
   // ✅ Verificare sempre
   class MyClass extends XotBaseClass
   ```

## Errori Comuni da Evitare

### ❌ Errore 1: Import diretto Filament
```php
use Filament\Pages\Dashboard; // ❌ SBAGLIATO
use Modules\Xot\Filament\Pages\XotBaseDashboard; // ✅ CORRETTO
```

### ❌ Errore 2: Estensione diretta
```php
class Dashboard extends Dashboard // ❌ SBAGLIATO
class Dashboard extends XotBaseDashboard // ✅ CORRETTO
```

### ❌ Errore 3: Namespace sbagliato
```php
namespace Modules\MyModule\Filament\Pages;
use Filament\Pages\Dashboard; // ❌ SBAGLIATO
```

## Checklist Pre-Implementazione

- [ ] Ho verificato che esiste una classe XotBase corrispondente?
- [ ] Ho importato la classe XotBase corretta?
- [ ] La mia classe estende XotBase e non Filament direttamente?
- [ ] Ho seguito il pattern degli altri moduli?
- [ ] Ho verificato la documentazione esistente?

## Conclusione

**Questa regola è CRITICA e NON deve mai essere dimenticata.**

Ogni volta che si crea una classe Filament, verificare SEMPRE che estenda una classe XotBase corrispondente.

---

*Regola creata il: 2025-07-30*
*Priorità: CRITICA*
*Stato: ATTIVA*
*Verifiche: SEMPRE* 