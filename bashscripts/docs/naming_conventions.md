# Convenzioni di Naming

## File di Documentazione

### README.md
- Il file README.md DEVE essere scritto in maiuscolo: `README.md`
- Motivazioni:
  1. Standard Storico: È una convenzione che risale ai primi sistemi Unix, dove i file in maiuscolo apparivano per primi nella directory
  2. Visibilità: Il nome in maiuscolo lo rende immediatamente visibile e distinguibile
  3. Convenzione GitHub: GitHub e altre piattaforme di hosting del codice lo riconoscono automaticamente come documentazione principale
  4. Compatibilità: Garantisce la massima compatibilità cross-platform

### Altri File di Documentazione
- Tutti gli altri file di documentazione DEVONO essere in minuscolo
- Esempi corretti:
  - `bottlenecks.md`
  - `roadmap.md`
  - `changelog.md`
  - `contributing.md`
- Motivazione: Mantiene uniformità e leggibilità nel codebase

## Struttura Directory docs/
```
docs/
├── README.md           # Documentazione principale (MAIUSCOLO)
├── bottlenecks.md     # File specifici (minuscolo)
├── roadmap.md
├── changelog.md
└── ...
```

## Collegamenti Bidirezionali
- [Struttura Moduli](./structure.md)
- [Convenzioni Codice](./code_conventions.md)
- [Best Practices](./best_practices.md)

## Riferimenti
- [GitHub Documentation](https://docs.github.com/en/repositories/managing-your-repository/about-readmes)

- [Unix File Naming Conventions](https://www.ibm.com/docs/en/aix/7.2?topic=files-naming-conventions) 
## Collegamenti tra versioni di naming_conventions.md
* [naming_conventions.md](../../laravel/Modules/Xot/docs/naming_conventions.md)

