# Struttura degli Script Bash

## Organizzazione delle Cartelle

```
bashscripts/
├── git/                    # Operazioni Git
│   ├── subtrees/          # Gestione subtrees
│   ├── submodules/        # Gestione submodules
│   └── maintenance/       # Manutenzione repository
│
├── system/                # Setup e Configurazione Sistema
│   ├── setup/            # Script di setup iniziale
│   └── config/           # Configurazioni
│
├── maintenance/           # Script di Manutenzione
│   ├── fixes/            # Correzioni e riparazioni
│   ├── backup/           # Script di backup
│   └── cleanup/          # Pulizia e ottimizzazione
│
├── testing/              # Script di Test e Qualità
│   ├── phpstan/          # Configurazione e script PHPStan
│   ├── mysql/            # Test database
│   └── forms/            # Validazione form
│
├── docs/                 # Documentazione
│   ├── update/          # Script aggiornamento docs
│   └── templates/       # Template documentazione
│
└── utils/               # Utility Generiche
    ├── composer/        # Script gestione Composer
    └── helpers/         # Script di supporto
```

## Categorizzazione degli Script

### Git Operations
- Gestione repository
- Operazioni su subtrees e submodules
- Sincronizzazione e merge
- Risoluzione conflitti

### System Setup
- Setup iniziale server
- Configurazione ambiente
- Inizializzazione progetto
- Setup composer

### Maintenance
- Fix struttura directory
- Correzione errori
- Backup
- Pulizia

### Testing & Quality
- Check PHPStan
- Validazione form
- Test MySQL
- Controlli qualità

### Documentation
- Aggiornamento docs
- Generazione documentazione
- Template e strutture

### Utils
- Script composer
- Helper generici
- Tool di supporto

## Convenzioni di Naming

1. **Prefissi per Categoria**
   - `git_` - Operazioni Git
   - `setup_` - Script di setup
   - `fix_` - Script di correzione
   - `check_` - Script di verifica
   - `update_` - Script di aggiornamento

2. **Suffissi Comuni**
   - `_init` - Inizializzazione
   - `_cleanup` - Pulizia
   - `_sync` - Sincronizzazione
   - `_test` - Testing

3. **Versioning**
   - Non usare suffissi `.old`
   - Usare versionamento Git
   - Mantenere changelog

## Best Practices

1. **Documentazione**
   - Header con descrizione
   - Requisiti e dipendenze
   - Esempi di utilizzo
   - Gestione errori

2. **Struttura Script**
   - Variabili configurabili all'inizio
   - Funzioni ben documentate
   - Gestione errori
   - Log delle operazioni

3. **Manutenzione**
   - Review periodica
   - Test automatizzati
   - Backup prima delle modifiche
   - Changelog aggiornato

## Collegamenti

- [Git Scripts Documentation](git/README.md)
- [System Setup Guide](system/README.md)
- [Maintenance Scripts](maintenance/README.md)
- [Testing Tools](testing/README.md)
- [Documentation Tools](docs/README.md) 

## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](laravel/Modules/Gdpr/docs/structure.md)
* [structure.md](laravel/Modules/Notify/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/base/structure.md)
* [structure.md](laravel/Modules/Xot/docs/config/structure.md)
* [structure.md](laravel/Modules/User/docs/structure.md)
* [structure.md](laravel/Modules/UI/docs/structure.md)
* [structure.md](laravel/Modules/Lang/docs/structure.md)
* [structure.md](laravel/Modules/Job/docs/structure.md)
* [structure.md](laravel/Modules/Media/docs/structure.md)
* [structure.md](laravel/Modules/Tenant/docs/structure.md)
* [structure.md](laravel/Modules/Activity/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/themes/structure.md)
* [structure.md](laravel/Modules/Cms/docs/components/structure.md)

