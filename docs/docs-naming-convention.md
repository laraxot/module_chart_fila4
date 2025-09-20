# Convenzione Naming per Cartelle Docs

## ⚠️ REGOLA CRITICA ⚠️

**TUTTI** i file e le cartelle nelle cartelle `docs` DEVONO essere in **MINUSCOLO**:
- ✅ CORRETTO: `readme.md`, `project.md`, `technical.md`
- ❌ ERRATO: `README.md`, `PROJECT.md`, `TECHNICAL.md`

## Motivazione
- Coerenza con le convenzioni di documentazione
- Compatibilità cross-platform
- Facilità di manutenzione
- Standardizzazione del progetto

## Applicazione
Questa regola si applica a:
- Tutte le cartelle `docs/` del progetto
- Tutti i file `.md` nelle cartelle docs
- Tutte le sottocartelle delle cartelle docs
- Qualsiasi file di documentazione

## Procedura per Correzione
Quando si identificano file con caratteri maiuscoli:

1. **Identificare i file problematici**:
   ```bash
   find docs -name "*[A-Z]*" -type f
   ```

2. **Rinominare in minuscolo**:
   ```bash
   mv docs/README.md docs/readme.md
   mv docs/PROJECT.md docs/project.md
   ```

3. **Verificare la correzione**:
   ```bash
   find docs -name "*[A-Z]*" -type f
   # Dovrebbe restituire nessun risultato
   ```

## Eccezioni
- **Nessuna eccezione**: Tutti i file devono essere in minuscolo
- **Nessun caso speciale**: Anche i file importanti come README devono essere `readme.md`

## Comandi Utili
```bash
# Trova tutti i file con caratteri maiuscoli
find docs -name "*[A-Z]*" -type f

# Trova tutte le cartelle con caratteri maiuscoli
find docs -name "*[A-Z]*" -type d

# Rinomina tutti i README.md in readme.md
find docs -name "README.md" -type f -exec bash -c 'mv "$1" "$(dirname "$1")/readme.md"' _ {} \;
```

## Checklist
- [ ] Verificare che tutti i file siano in minuscolo
- [ ] Verificare che tutte le cartelle siano in minuscolo
- [ ] Aggiornare tutti i riferimenti nei file
- [ ] Documentare la correzione
- [ ] Aggiornare regole e memorie

## Collegamenti
- [Correzione Naming 2025-01-27](readme-naming-correction-2025-01-27.md)

*Ultimo aggiornamento: 2025-01-27* 