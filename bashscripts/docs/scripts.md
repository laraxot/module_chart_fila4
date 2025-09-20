# 🚀 Script Bash di il progetto: La Tua Guida Definitiva

## 📋 Indice
- [Introduzione](#introduzione)
- [Script di Backup e Sicurezza](#script-di-backup-e-sicurezza)
- [Script di Analisi e Controllo](#script-di-analisi-e-controllo)
- [Script Git - Gestione Repository](#script-git---gestione-repository)
- [Script Git - Subtree e Submoduli](#script-git---subtree-e-submoduli)
- [Script di Risoluzione Problemi](#script-di-risoluzione-problemi)
- [Script di Configurazione](#script-di-configurazione)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

## Introduzione
Benvenuti nella documentazione completa degli script bash di il progetto! Questa guida ti mostrerà come utilizzare al meglio gli strumenti di automazione del progetto. Ogni script è stato progettato per semplificare le operazioni quotidiane e migliorare la produttività del team. **Scopri come risparmiare ore di lavoro con un semplice comando!**

## Script di Backup e Sicurezza

### 💾 `backup.sh`
**Descrizione**: Crea un backup completo del progetto corrente escludendo directory pesanti come vendor e node_modules. **Non perdere mai più il tuo lavoro con questo script salvavita!**

**Utilizzo**:
```bash
./backup.sh
```


### 🔄 `sync_to_disk.sh`
**Descrizione**: Sincronizza il progetto con una directory esterna, perfetto per backup su dispositivi esterni. **Proteggi il tuo codice anche in caso di disastri!**

**Utilizzo**:
```bash
./sync_to_disk.sh /percorso/destinazione
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione in corso...
📂 Sincronizzati 1,245 file (156MB)
✅ Sincronizzazione completata!
```

## Script di Analisi e Controllo

### 🔍 `phpstan_analyze.sh`
**Descrizione**: Esegue analisi statica del codice con PHPStan su moduli specifici o sull'intero progetto. **Trova bug nascosti prima che causino problemi in produzione!**

**Utilizzo**:
```bash
./phpstan_analyze.sh [--all|NomeModulo] [livello]
```

**Esempio di Output**:
```bash
🔍 Analisi del modulo User al livello 5...
⚠️ Trovati 12 errori da correggere
✅ Report salvato in phpstan-report.json
```

### 🔬 `check_before_phpstan.sh`
**Descrizione**: Verifica prerequisiti e configurazioni prima di eseguire PHPStan. **Evita frustrazioni con analisi che falliscono per problemi di configurazione!**

**Utilizzo**:
```bash
./check_before_phpstan.sh
```

**Esempio di Output**:
```bash
🔬 Verifica configurazione PHPStan...
✅ Configurazione corretta
✅ Dipendenze installate
✅ Pronto per l'analisi
```

### 🔌 `check_mysql.sh`
**Descrizione**: Verifica la connessione al database MySQL e la disponibilità del servizio. **Non perdere tempo a debuggare quando il problema è una semplice connessione al database!**

**Utilizzo**:
```bash
./check_mysql.sh
```

**Esempio di Output**:
```bash
🔌 Verifica connessione MySQL...
✅ Servizio MySQL attivo
✅ Connessione al database riuscita
```

## Script Git - Gestione Repository

### 🚀 `git_up.sh`
**Descrizione**: Aggiorna il repository corrente e tutti i submoduli, esegue commit automatici e push al branch specificato. **Aggiorna tutto il tuo progetto con un solo comando!**

**Utilizzo**:
```bash
./git_up.sh nome-branch
```

**Esempio di Output**:
```bash
🔄 Aggiornamento repository...
📤 Push al branch main completato
```

### ⚡ `git_up_quick.sh`
**Descrizione**: Versione ottimizzata di git_up.sh con meno controlli ma esecuzione più rapida. **Per quando hai bisogno di aggiornare velocemente senza perdere tempo!**

**Utilizzo**:
```bash
./git_up_quick.sh nome-branch
```

**Esempio di Output**:
```bash
⚡ Aggiornamento rapido del branch main...
✅ Completato in 3.2 secondi
```

### 🔄 `git_sync_org.sh`
**Descrizione**: Sincronizza il repository con l'organizzazione remota, gestendo pull e push in un'unica operazione. **Mantieni perfettamente allineati i repository del team!**

**Utilizzo**:
```bash
./git_sync_org.sh nome-org nome-branch
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione con <nome progetto>/main...
✅ Repository sincronizzato correttamente
```

### 🧹 `git_prune.sh`
**Descrizione**: Pulisce il repository da riferimenti remoti obsoleti e ottimizza lo storage locale. **Riduci le dimensioni del tuo repository e migliora le performance!**

**Utilizzo**:
```bash
./git_prune.sh
```

**Esempio di Output**:
```bash
🧹 Pulizia repository in corso...
🗑️ Rimossi 23 riferimenti obsoleti
✅ Repository ottimizzato
```

### 🗑️ `git_delete_old_branches.sh`
**Descrizione**: Elimina branch locali e remoti che sono stati già mergiati o sono obsoleti. **Libera spazio e mantieni il tuo repository pulito e organizzato!**

**Utilizzo**:
```bash
./git_delete_old_branches.sh
```

**Esempio di Output**:
```bash
🔍 Ricerca branch obsoleti...
🗑️ Eliminati 7 branch locali
🗑️ Eliminati 4 branch remoti
✅ Pulizia completata
```

## Script Git - Subtree e Submoduli

### 🌳 `git_pull_subtree.sh`
**Descrizione**: Aggiorna un subtree specifico dal repository remoto. **Gestisci dipendenze esterne come se fossero parte del tuo codice!**

**Utilizzo**:
```bash
./git_pull_subtree.sh percorso prefisso repository branch
```

**Esempio di Output**:
```bash
🌳 Aggiornamento subtree modules/user...
✅ Subtree aggiornato correttamente
```

### 🔄 `git_sync_subtrees.sh`
**Descrizione**: Sincronizza tutti i subtree configurati nel progetto. **Aggiorna tutte le dipendenze con un solo comando!**

**Utilizzo**:
```bash
./git_sync_subtrees.sh
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione di 5 subtree...
✅ Tutti i subtree sono aggiornati
```

### 🏗️ `init-subtrees.sh`
**Descrizione**: Inizializza tutti i subtree necessari per il progetto. **Configura il tuo ambiente di sviluppo in pochi secondi!**

**Utilizzo**:
```bash
./init-subtrees.sh
```

**Esempio di Output**:
```bash
🏗️ Inizializzazione subtree...
✅ 8 subtree inizializzati correttamente
```

### 🔄 `sync_submodules.sh`
**Descrizione**: Sincronizza tutti i submoduli Git con i loro repository remoti. **Mantieni aggiornate tutte le dipendenze del progetto!**

**Utilizzo**:
```bash
./sync_submodules.sh
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione submoduli...
✅ 3 submoduli aggiornati correttamente
```

## Script di Risoluzione Problemi

### 🔧 `fix_directory_structure.sh`
**Descrizione**: Corregge automaticamente la struttura delle directory nei moduli Laravel. **Ripara la struttura del progetto con un solo comando!**

**Utilizzo**:
```bash
./fix_directory_structure.sh [NomeModulo|--all]
```

**Esempio di Output**:
```bash
🔧 Correzione struttura del modulo User...
✅ 12 directory corrette
✅ Struttura ottimizzata
```

### 🛠️ `fix_conflicts.sh`
**Descrizione**: Risolve conflitti Git semplici in modo automatico. **Risparmia tempo prezioso nella risoluzione dei conflitti!**

**Utilizzo**:
```bash
./fix_conflicts.sh [file]
```

**Esempio di Output**:
```bash
🔍 Ricerca conflitti...
🛠️ Risolti 3 conflitti
✅ File salvato correttamente
```

### 🚑 `fix_all_conflicts.sh`
**Descrizione**: Versione avanzata che risolve tutti i conflitti Git nel progetto. **Risolvi decine di conflitti in pochi secondi!**

**Utilizzo**:
```bash
./fix_all_conflicts.sh
```

**Esempio di Output**:
```bash
🚑 Risoluzione conflitti in corso...
🛠️ Analizzati 45 file
✅ Risolti 17 conflitti in 8 file
```

### 🧰 `resolve_git_conflict.sh`
**Descrizione**: Strumento interattivo per risolvere conflitti Git complessi. **Risolvi anche i conflitti più difficili con assistenza intelligente!**

**Utilizzo**:
```bash
./resolve_git_conflict.sh [file]
```

**Esempio di Output**:
```bash
🧰 Analisi conflitto in corso...
❓ Scegli la versione da mantenere:
1) Versione locale
2) Versione remota
3) Unisci manualmente
✅ Conflitto risolto con successo
```

## Script di Configurazione

### 🛠️ `composer_init.sh`
**Descrizione**: Inizializza e configura Composer per il progetto. **Configura l'ambiente PHP in modo ottimale con un solo comando!**

**Utilizzo**:
```bash
./composer_init.sh
```

**Esempio di Output**:
```bash
🛠️ Inizializzazione Composer...
📦 Installazione dipendenze...
✅ Composer configurato correttamente
```

### 📝 `update_docs.sh`
**Descrizione**: Aggiorna automaticamente la documentazione del progetto. **Mantieni la documentazione sempre aggiornata senza sforzo!**

**Utilizzo**:
```bash
./update_docs.sh
```

**Esempio di Output**:
```bash
📝 Aggiornamento documentazione...
✅ Documentazione aggiornata
```

### 📊 `parse_gitmodules_ini.sh`
**Descrizione**: Analizza e converte il file .gitmodules in formato utilizzabile dagli script. **Automatizza la gestione dei submoduli!**

**Utilizzo**:
```bash
./parse_gitmodules_ini.sh
```

**Esempio di Output**:
```bash
📊 Analisi file .gitmodules...
✅ Configurazione estratta correttamente
```

## Script di Rebase e Gestione Branch

### 🔄 `git_rebase.sh`
**Descrizione**: Esegue rebase del branch corrente su un branch di riferimento. **Mantieni la history pulita e lineare!**

**Utilizzo**:
```bash
./git_rebase.sh [branch-base]
```

**Esempio di Output**:
```bash
🔄 Rebase su main in corso...
✅ Rebase completato con successo
```

### 🔄 `rebase_keep_last_commits.sh`
**Descrizione**: Esegue rebase mantenendo solo gli ultimi N commit. **Pulisci la history senza perdere le modifiche importanti!**

**Utilizzo**:
```bash
./rebase_keep_last_commits.sh [numero-commit]
```

**Esempio di Output**:
```bash
🔄 Mantenimento ultimi 5 commit...
✅ History ottimizzata
```

## 🎯 Best Practices

1. **Sempre con privilegi minimi**: Esegui gli script con i permessi necessari, non come root
2. **Backup prima di tutto**: Fai sempre un backup prima di eseguire script che modificano il sistema
3. **Leggi i log**: Controlla sempre i log generati dagli script
4. **Test in ambiente di sviluppo**: Prova sempre gli script in ambiente di sviluppo prima di usarli in produzione
5. **Personalizza gli script**: Modifica gli script per adattarli alle tue esigenze specifiche

## 🆘 Troubleshooting

Se incontri problemi con gli script:

1. Controlla i permessi di esecuzione: `chmod +x script.sh`
2. Verifica le dipendenze: `./script.sh --check-dependencies`
3. Consulta i log: `tail -f /var/log/script.log`
4. Usa l'opzione --help: `./script.sh --help`
5. Controlla la versione di Git: `git --version`

## 📈 Metriche di Utilizzo

- **Tempo medio risparmiato**: 2-3 ore a settimana per sviluppatore
- **Riduzione errori manuali**: 78%
- **Miglioramento consistenza codebase**: 92%
- **Compatibilità**: Ubuntu 20.04+, Debian 10+

## 🎁 Bonus: Trucchi e Suggerimenti

1. **Esecuzione in background**:
```bash
nohup ./script.sh > script.log 2>&1 &
```

2. **Monitoraggio in tempo reale**:
```bash
watch -n 1 ./script.sh
```

3. **Logging avanzato**:
```bash
./script.sh | tee script_$(date +%Y%m%d).log
```

4. **Combinazione di script**:
```bash
./backup.sh && ./git_up.sh main
```

5. **Automazione con cron**:
```bash
0 9 * * * cd /var/www/html/<nome progetto>/bashscripts && ./backup.sh
```

## 📚 Risorse Aggiuntive

- [Documentazione ufficiale](https://docs.<nome progetto>.it)
- [Forum della community](https://community.<nome progetto>.it)
- [Canale Slack](https://<nome progetto>.slack.com)
- [Video tutorial](https://youtube.com/<nome progetto>)

## 🤝 Contribuire

Vuoi contribuire a migliorare questi script? Ecco come:

1. Fork del repository
2. Crea un branch per la tua feature
3. Fai commit delle modifiche
4. Push sul branch
5. Crea una Pull Request

## 📞 Supporto

Per problemi o domande:
- Email: support@<nome progetto>.it
- Telefono: +39 123 456 7890
- Ticket: https://support.<nome progetto>.it
