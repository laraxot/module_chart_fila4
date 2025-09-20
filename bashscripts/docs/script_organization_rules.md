# Regole Organizzazione Script

## Regola Fondamentale

**TUTTI GLI SCRIPT DEVONO ESSERE POSIZIONATI IN `bashscripts/`**

### Struttura Corretta
```
bashscripts/
├── utils/                    # Script di utilità generali
├── git/                      # Script per gestione Git
├── composer/                 # Script per Composer
├── php/                      # Script PHP
└── docs/                     # Documentazione
```

## Regole Specifiche

### 1. Posizionamento
- ✅ **CORRETTO**: `bashscripts/utils/fix_encryption_error.sh`
- ❌ **ERRATO**: `laravel/fix_encryption_error.sh`

### 2. Categorizzazione
- **utils/**: Script di utilità generali
- **git/**: Script per gestione Git
- **composer/**: Script per gestione Composer
- **php/**: Script PHP
- **docs/**: Documentazione

### 3. Permessi
```bash
chmod +x bashscripts/utils/script.sh
```

## Regole di Memoria per AI

1. **MAI** creare script fuori da `bashscripts/`
2. **SEMPRE** categorizzare appropriatamente
3. **SEMPRE** documentare in `bashscripts/docs/`
4. **SEMPRE** rendere eseguibili con `chmod +x`

---

*Regole create il: $(date)*
## Docs Naming Convention

**REGOLA CRITICA**: Nelle cartelle docs, né i nomi dei file né i nomi delle cartelle devono contenere caratteri maiuscoli.

- **UNICA ECCEZIONE**: README.md (deve rimanere in maiuscolo)
- Tutti gli altri file e cartelle devono essere in minuscolo
- Questa regola ha priorità assoluta e deve essere sempre rispettata
- Esempi corretti:
  - ✅ README.md
  - ✅ api-documentation.md
  - ✅ best-practices.md
  - ✅ database-structure.md
- Esempi sbagliati:
  - ❌ AddressResource_Analysis.md
  - ❌ API-Documentation.md
  - ❌ BestPractices.md

