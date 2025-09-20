#!/bin/bash

# Script to audit and fix naming conventions in docs folders
# RULE: Only README.md can have uppercase letters; all other files and folders must be lowercase

PROJECT_ROOT="/var/www/html/_bases/base_techplanner_fila3_mono"
VIOLATIONS_FOUND=0
FIXES_APPLIED=0

echo "🔍 Auditing docs folders for naming convention violations..."
echo "📋 RULE: Only README.md can have uppercase letters; all other files and folders must be lowercase"
echo ""

# Function to check and fix naming violations
fix_naming_violations() {
    local docs_path="$1"
    echo "📁 Processing: $docs_path"
    
    # Find all files and directories in docs folder (excluding vendor)
    find "$docs_path" -type f -o -type d | while read -r item; do
        # Skip if it's the docs folder itself
        if [[ "$item" == "$docs_path" ]]; then
            continue
        fi
        
        # Get just the filename/dirname
        basename_item=$(basename "$item")
        dirname_item=$(dirname "$item")
        
        # Skip README.md (allowed to have uppercase)
        if [[ "$basename_item" == "README.md" ]]; then
            continue
        fi
        
        # Check if basename contains uppercase letters
        if [[ "$basename_item" =~ [A-Z] ]]; then
            echo "   ⚠️  VIOLATION: $item"
            ((VIOLATIONS_FOUND++))
            
            # Generate lowercase version
            lowercase_name=$(echo "$basename_item" | tr '[:upper:]' '[:lower:]')
            new_path="$dirname_item/$lowercase_name"
            
            # Check if target already exists
            if [[ -e "$new_path" && "$new_path" != "$item" ]]; then
                echo "      ❌ Cannot rename: target already exists: $new_path"
            else
                echo "      🔄 Renaming: $basename_item -> $lowercase_name"
                mv "$item" "$new_path"
                ((FIXES_APPLIED++))
            fi
        fi
    done
}

# Find all docs directories (excluding vendor)
find "$PROJECT_ROOT" -type d -name "docs" -not -path "*/vendor/*" | while read -r docs_dir; do
    fix_naming_violations "$docs_dir"
done

echo ""
echo "📊 Summary:"
echo "   ⚠️  Violations found: $VIOLATIONS_FOUND"
echo "   🔄 Fixes applied: $FIXES_APPLIED"
echo ""

# Update the script organization rules to include this naming convention
RULES_FILE="$PROJECT_ROOT/bashscripts/docs/script_organization_rules.md"
if [[ -f "$RULES_FILE" ]]; then
    echo "📝 Updating script organization rules..."
    
    # Check if the docs naming rule already exists
    if ! grep -q "docs naming convention" "$RULES_FILE"; then
        cat >> "$RULES_FILE" << 'EOF'

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

EOF
        echo "   ✅ Added docs naming convention to rules"
    else
        echo "   ℹ️  Docs naming convention already documented"
    fi
fi

echo "✨ Docs naming audit and fix completed!"
