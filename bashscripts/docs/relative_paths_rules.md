# Regole per i Percorsi Relativi nella Documentazione

> **Collegamenti correlati**
> - [README.md documentazione generale](../../docs/README.md)
> - [Regole per i Percorsi Relativi (Xot)](../../laravel/Modules/Xot/docs/RELATIVE_PATHS_RULES.md)
> - [README.md toolkit bashscripts](../README.md)

## Regola Fondamentale

**MAI UTILIZZARE PERCORSI ASSOLUTI NEI LINK DELLA DOCUMENTAZIONE. SEMPRE UTILIZZARE PERCORSI RELATIVI.**

Questa regola è fondamentale per garantire la portabilità della documentazione e il corretto funzionamento dei link indipendentemente dall'ambiente di installazione.

## Percorsi Corretti

### Da un file in bashscripts verso la root del progetto

```markdown
[Documentazione Root](../../docs/README.md)
```

### Da un file in bashscripts verso un modulo

```markdown
[Modulo Xot](../../laravel/Modules/Xot/docs/README.md)
```

### Da un file in bashscripts verso un altro file in bashscripts

```markdown
[README.md toolkit bashscripts](../README.md)
```

## Errori Comuni da Evitare

1. **MAI utilizzare percorsi assoluti** come:
   ```markdown
   [ERRATO](../../../laravel/Modules/Xot/docs/README.md)
   ```

2. **MAI utilizzare percorsi che iniziano con /**:
   ```markdown
   [ERRATO](/docs/README.md)
   [ERRATO](/bashscripts/docs/README.md)
   ```

3. **MAI utilizzare percorsi che non tengono conto della posizione relativa del file sorgente**:
   ```markdown
   [ERRATO](../../../laravel/Modules/Xot/docs/README.md) <!-- Senza considerare che serve salire di due livelli -->
   ```
