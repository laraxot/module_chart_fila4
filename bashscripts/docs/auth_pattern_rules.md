# Regole Pattern Autenticazione - Aggiornamento Critico

## REGOLA CRITICA - PRIORITÀ ASSOLUTA

**Per i form di autenticazione utilizzare SEMPRE widget Filament, NON Volt!**

## Pattern Corretto Identificato

### 1. Namespace Corretto
```
Modules\User\Filament\Widget\Auth\
├── Login.php
├── Register.php
├── PasswordReset.php
└── Logout.php
```

### 2. Convenzioni di Naming
- **Classe**: `Login` (non `LoginWidget`)
- **Namespace**: `Widget\Auth` (non `Widgets\Auth`)
- **File**: `Login.php` (non `LoginWidget.php`)

### 3. Pattern di Utilizzo
```blade
{{-- CORRETTO --}}
@livewire(\Modules\User\Filament\Widget\Auth\Login::class)
@livewire(\Modules\User\Filament\Widget\Auth\Register::class)
@livewire(\Modules\User\Filament\Widget\Auth\PasswordReset::class)
```

## Regole da Memorizzare SEMPRE

### 1. REGOLA CRITICA - Form di Autenticazione
```blade
{{-- SEMPRE usare widget Filament per form di autenticazione --}}
@livewire(\Modules\User\Filament\Widget\Auth\Login::class)
```

### 2. REGOLA - Namespace Corretto
- **Widget**: `Modules\User\Filament\Widget\Auth\`
- **Classe**: `Login` (non `LoginWidget`)
- **File**: `Login.php` (non `LoginWidget.php`)

### 3. REGOLA - Pattern di Utilizzo
- **Form complessi**: Widget Filament
- **Logica semplice**: Volt
- **Autenticazione**: SEMPRE Widget Filament

### 4. REGOLA - Studio Precedente
- **Prima di implementare**: Studiare sempre la documentazione esistente
- **Verificare**: L'implementazione effettiva, non solo la documentazione
- **Testare**: Verificare che il namespace sia corretto

## Errori Comuni da Evitare

### 1. Namespace Sbagliato
```blade
{{-- ERRATO --}}
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)

{{-- CORRETTO --}}
@livewire(\Modules\User\Filament\Widget\Auth\Login::class)
```

### 2. Usare Volt per Form Complessi
```blade
{{-- ERRATO --}}
@volt('auth.login')
@volt('auth.register')

{{-- CORRETTO --}}
@livewire(\Modules\User\Filament\Widget\Auth\Login::class)
@livewire(\Modules\User\Filament\Widget\Auth\Register::class)
```

### 3. Naming Inconsistente
```php
// ERRATO
class LoginWidget extends XotBaseWidget

// CORRETTO
class Login extends XotBaseWidget
```

## Pattern per Pagine di Autenticazione

### 1. Layout Semplice con Widget
```blade
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('login');
?>

<x-layouts.main>
    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            {{-- Logo e header --}}
            <div class="text-center mb-8">
                <a href="{{ url('/' . app()->getLocale()) }}" class="inline-block">
                    <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
                </a>
            </div>

            {{-- Filament Widget per il login --}}
            <div class="px-10 py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @livewire(\Modules\User\Filament\Widget\Auth\Login::class)
            </div>
        </div>
    </div>
</x-layouts.main>
```

### 2. Volt Solo per Logica Semplice
```blade
@volt('auth.logout')
    use Illuminate\Support\Facades\Auth;
    use function Livewire\Volt\{mount};

    mount(function() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->to('/' . app()->getLocale());
    });
@endvolt

<x-layouts.main>
    <div class="text-center">
        <p>{{ __('Logout in corso...') }}</p>
    </div>
</x-layouts.main>
```

## Documentazione di Riferimento

### 1. File da Studiare SEMPRE
- `laravel/Modules/User/docs/auth_widget_rules.md`
- `laravel/Modules/User/docs/auth_pages_implementation.md`
- `laravel/Modules/User/docs/auth_login_implementation.md`

### 2. Pattern da Riconoscere
- **Widget Filament**: Per form complessi
- **Volt**: Per logica semplice
- **Namespace**: `Widget\Auth\Login`

### 3. Convenzioni da Seguire
- **Naming**: `Login` non `LoginWidget`
- **Namespace**: `Widget\Auth` non `Widgets\Auth`
- **Utilizzo**: `@livewire(\Modules\User\Filament\Widget\Auth\Login::class)`

## Aggiornamento Regole Interne

### 1. Pattern Recognition
- **Form di autenticazione**: SEMPRE widget Filament
- **Namespace**: Verificare sempre l'implementazione effettiva
- **Naming**: Seguire le convenzioni del progetto

### 2. Studio Precedente
- **Prima di implementare**: Studiare la documentazione esistente
- **Verificare**: L'implementazione effettiva
- **Testare**: Il namespace e la classe

### 3. Convenzioni da Memorizzare
- **Widget Filament**: `Modules\User\Filament\Widget\Auth\Login`
- **Volt**: Solo per logica semplice
- **Form complessi**: SEMPRE widget Filament

## Checklist per Implementazione

### Prima di Implementare
- [ ] Studiare la documentazione esistente
- [ ] Verificare l'implementazione effettiva
- [ ] Controllare il namespace corretto
- [ ] Verificare il naming delle classi

### Durante l'Implementazione
- [ ] Usare widget Filament per form complessi
- [ ] Usare Volt solo per logica semplice
- [ ] Seguire le convenzioni di naming
- [ ] Verificare il namespace corretto

### Dopo l'Implementazione
- [ ] Testare il funzionamento
- [ ] Verificare che il namespace sia corretto
- [ ] Controllare che il pattern sia seguito
- [ ] Documentare le modifiche

## Conclusione

Il pattern corretto per l'autenticazione è:
- **Form complessi**: Widget Filament (`Modules\User\Filament\Widget\Auth\Login`)
- **Logica semplice**: Volt
- **Sempre**: Verificare l'implementazione effettiva prima di implementare

---

*Regole aggiornate il: $(date)*
*Stato: Pattern corretto identificato*
*Priorità: CRITICA* 