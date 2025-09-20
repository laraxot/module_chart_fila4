# Git Conflict Cleanup Checklist

Questo file contiene l'elenco di tutti i file che contengono marcatori di conflitto Git che devono essere risolti.

**Data creazione**: 2025-07-30  
**Stato**: In corso

## File con conflitti Git da risolvere

### Bashscripts - Utils
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/utils/scripts_conflict_resolution.md` (linea 390)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/utils/resolve_conflicts.sh` (linea 48, 109) - *Nota: contiene riferimenti a marcatori, potrebbe essere codice valido*

### Bashscripts - Quality Assurance  
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/quality-assurance/code_quality.md` (linee 227, 286, 293)

### Bashscripts - Git Management
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git-management/git_conflicts_resolution.md` (linea 165)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git-management/git_scripts.md` (linee 180, 230, 232)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git-management/resolve_git_conflict.sh` (linea 53) - *Nota: contiene riferimenti a marcatori, potrebbe essere codice valido*
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git-management/git_subtree_conflicts.md` (linee 646, 779, 781)

### Bashscripts - Root Level
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/resolve_git_conflict.sh` (linea 53) - *Nota: contiene riferimenti a marcatori, potrebbe essere codice valido*

### Bashscripts - Git Folder
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git/git_subtree_conflicts.md` (linee 646, 779, 781)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git/git_scripts.md` (linee 180, 230, 232)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/git/git_conflicts_resolution.md` (linea 165)

### Bashscripts - Docs Folder
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/git_conflicts_resolution.md` (linea 165)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/git_scripts.md` (linee 180, 230, 232)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/config_file_conflicts.md` (linee 440, 541, 548)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/files_configuration.md` (linee 397, 478, 480)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/code_quality.md` (linee 227, 286, 293)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/git_subtree_conflicts.md` (linee 646, 779, 781)
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/bashscripts/docs/scripts_conflict_resolution.md` (linea 390)

### Laravel - Modules
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/docs/send_email_translation_fix.md` (linea 6) - *Nota: contiene riferimenti a marcatori, potrebbe essere documentazione*
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Media/docs/phpstan_level10_fixes.md` (linea 86) - *Nota: contiene riferimenti a marcatori, potrebbe essere documentazione*
- [ ] `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Geo/app/Filament/Resources/AddressResource.php` (linee 115, 123) - **PRIORITÀ ALTA: File PHP con conflitti**

## Statistiche
- **Totale file**: 23 file unici
- **File risolti**: 0
- **File rimanenti**: 23
- **File prioritari (codice PHP)**: 1

## Note
- I file con estensione `.sh` e `.md` che contengono riferimenti ai marcatori di conflitto potrebbero essere documentazione o script validi
- Il file PHP `AddressResource.php` ha priorità alta perché contiene veri conflitti di merge
- Alcuni file sembrano essere duplicati in cartelle diverse (git/, git-management/, docs/)

## Istruzioni per la risoluzione
1. Iniziare dal file PHP prioritario
2. Verificare se i file .sh contengono veri conflitti o solo riferimenti nei commenti
3. Per i file .md, controllare il contesto per determinare se sono veri conflitti
4. Spuntare ogni file dopo la risoluzione cambiando `[ ]` in `[x]`
