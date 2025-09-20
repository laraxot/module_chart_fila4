# convenzioni per i namespace nei moduli

questo documento è un collegamento alla documentazione completa disponibile nel modulo xot:

[vai alla documentazione completa](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/namespace_conventions.md)

## regola critica

**MAI** includere `App` o `app` nel namespace, anche se i file sono fisicamente nella cartella `app/`:

```php
// GRAVEMENTE ERRATO
namespace Modules\SaluteOra\App\Controllers;

// CORRETTO
namespace Modules\SaluteOra\Controllers;
```

## differenza tra percorso fisico e namespace

| percorso fisico | namespace corretto |
|-----------------|--------------------|
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |

per dettagli completi, consultare la [documentazione nel modulo xot](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/namespace_conventions.md).
