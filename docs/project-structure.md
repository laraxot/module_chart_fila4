# Struttura del Progetto

## Directory Root
Il progetto è strutturato con una directory root `/var/www/html/saluteora` che contiene:

```
/var/www/html/saluteora/
├── laravel/           # Directory principale dell'applicazione Laravel
│   ├── Modules/      # Moduli dell'applicazione
│   │   ├── Patient/
│   │   │   ├── app/
│   │   │   │   ├── Models/
│   │   │   │   ├── Http/
│   │   │   │   └── ...
│   │   │   ├── database/
│   │   │   │   ├── migrations/
│   │   │   │   └── seeders/
│   │   │   └── ...
│   │   └── ...
│   └── ...
├── docs/             # Documentazione del progetto
└── ...
```

## Regole Fondamentali

1. **Path Assoluti**:
   - La directory root è SEMPRE `/var/www/html/saluteora`
   - Tutti i moduli sono SEMPRE in `/var/www/html/saluteora/laravel/Modules/`
   - I modelli sono SEMPRE in `/var/www/html/saluteora/laravel/Modules/{Module}/app/Models/`
   - Le migration sono SEMPRE in `/var/www/html/saluteora/laravel/Modules/{Module}/database/migrations/`
   - I seeder sono SEMPRE in `/var/www/html/saluteora/laravel/Modules/{Module}/database/seeders/`

2. **Convenzioni di Naming**:
   - I nomi delle directory sono SEMPRE in minuscolo
   - I nomi dei file sono SEMPRE in PascalCase per le classi, kebab-case per gli altri
   - I namespace devono SEMPRE riflettere la struttura delle directory

3. **Verifica Path**:
   - Prima di ogni operazione, VERIFICARE SEMPRE il path corretto
   - Usare `list_dir` per verificare la struttura
   - Non assumere mai la struttura delle directory
   - Documentare sempre i path corretti

## Errori Comuni

1. **Errore**: Path errato per i modelli
   - ❌ `/var/www/html/saluteora/Modules/Patient/Models/User.php`
   - ✅ `/var/www/html/saluteora/laravel/Modules/Patient/app/Models/User.php`

2. **Errore**: Path errato per le migration
   - ❌ `/var/www/html/saluteora/Modules/Patient/Database/Migrations/`
   - ✅ `/var/www/html/saluteora/laravel/Modules/Patient/database/migrations/`

3. **Errore**: Path errato per i seeder
   - ❌ `/var/www/html/saluteora/Modules/Notify/database/seeders/`
   - ✅ `/var/www/html/saluteora/laravel/Modules/Notify/database/seeders/`

## Best Practices

1. **Verifica Struttura**:
   ```bash
   # Prima di ogni operazione
   list_dir /var/www/html/saluteora/laravel/Modules/{Module}
   ```

2. **Documentazione**:
   - Documentare SEMPRE i path corretti
   - Aggiornare la documentazione quando la struttura cambia
   - Includere esempi di path corretti

3. **Automazione**:
   - Usare script per verificare la struttura
   - Implementare check automatici sui path
   - Validare i path prima di ogni operazione

## Collegamenti

- [Convenzioni di Codice](../xot/coding-standards.md)
- [Struttura Moduli](../xot/modules.md)
- [Best Practices](../xot/best-practices.md) 
