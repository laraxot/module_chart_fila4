# Regole Struttura Progetto Laraxot

## Posizionamento File e Cartelle

### ✅ CORRETTO - Cartelle nella Root
- `bashscripts/` - Script di utilità e automazione
- `docs/` - Documentazione globale del progetto
- `laravel/` - Applicazione Laravel principale
- `public_html/` - File pubblici
- `.windsurf/` - Configurazione Windsurf
- `.cursor/` - Configurazione Cursor

### ❌ ERRATO - Cartelle NON Permesse nella Root
- `conflict-resolution-docs/` - NON deve essere nella root
- `temp/` - File temporanei non nella root
- `backup/` - Backup non nella root
- Qualsiasi cartella di documentazione specifica di moduli

## Motivazione

### Separazione delle Responsabilità
- **Root**: Solo configurazione globale e struttura principale
- **Moduli**: Documentazione specifica nei rispettivi moduli
- **Script**: Automazione e utilità in `bashscripts/`

### Manutenibilità
- Struttura pulita e organizzata
- Facile identificazione delle responsabilità
- Evitare confusione tra documentazione globale e specifica

### Compliance Architetturale
- Rispetto della struttura modulare Laraxot
- Documentazione specifica nei moduli corrispondenti
- Script di utilità centralizzati

## Regole Specifiche

### Documentazione
- **Globale**: `docs/` (root)
- **Moduli**: `laravel/Modules/{ModuleName}/docs/`
- **Script**: `bashscripts/docs/`

### Script e Utilità
- **Automazione**: `bashscripts/`
- **Configurazione**: Root del progetto
- **Temporanei**: Mai nella root

### File di Configurazione
- **Laravel**: `laravel/`
- **Progetto**: Root
- **IDE**: `.vscode/`, `.cursor/`, `.windsurf/`

## Checklist

- [ ] Nessuna cartella di documentazione specifica nella root
- [ ] Script solo in `bashscripts/`
- [ ] Documentazione moduli nei rispettivi moduli
- [ ] Struttura pulita e organizzata
- [ ] Compliance architetturale

## Esempi

### ✅ CORRETTO
```
/
├── bashscripts/
├── docs/
├── laravel/
│   └── Modules/
│       └── Employee/
│           └── docs/
├── public_html/
└── .windsurf/
```

### ❌ ERRATO
```
/
├── conflict-resolution-docs/  # NON permesso
├── employee-docs/            # NON permesso
├── temp/                     # NON permesso
└── laravel/
```

## Aggiornamento Regole

Quando si identifica una cartella non appropriata nella root:
1. **Identificare** la destinazione corretta
2. **Spostare** i file nella posizione appropriata
3. **Aggiornare** i riferimenti
4. **Documentare** la correzione
5. **Aggiornare** le regole per prevenire ricorrenze

*Ultimo aggiornamento: 2025-01-06* 