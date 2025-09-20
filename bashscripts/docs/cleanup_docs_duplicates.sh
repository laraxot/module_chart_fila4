#!/bin/bash

# Script to clean up duplicate docs files (remove uppercase versions when lowercase exists)
# RULE: Only README.md can have uppercase letters; all other files and folders must be lowercase

PROJECT_ROOT="/var/www/html/_bases/base_techplanner_fila3_mono"
REMOVED_COUNT=0
CONFLICTS_RESOLVED=0

echo "🧹 Cleaning up docs naming conflicts..."
echo "📋 RULE: Removing uppercase files when lowercase equivalents exist"
echo ""

# Function to clean up naming conflicts
cleanup_conflicts() {
    local docs_path="$1"
    echo "📁 Processing: $docs_path"
    
    # Find all files and directories with uppercase letters (excluding README.md)
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
            # Generate lowercase version path
            lowercase_name=$(echo "$basename_item" | tr '[:upper:]' '[:lower:]')
            lowercase_path="$dirname_item/$lowercase_name"
            
            # Check if lowercase version already exists
            if [[ -e "$lowercase_path" && "$lowercase_path" != "$item" ]]; then
                echo "   🔄 CONFLICT FOUND:"
                echo "      ❌ Uppercase: $basename_item"
                echo "      ✅ Lowercase: $lowercase_name (exists)"
                echo "      🗑️  Removing uppercase version..."
                
                # Remove the uppercase version
                if [[ -d "$item" ]]; then
                    rm -rf "$item"
                else
                    rm -f "$item"
                fi
                
                ((REMOVED_COUNT++))
                ((CONFLICTS_RESOLVED++))
                echo "      ✅ Removed: $basename_item"
            else
                echo "   ⚠️  UPPERCASE FOUND (no lowercase equivalent): $basename_item"
                echo "      🔄 Renaming to lowercase..."
                
                # Rename to lowercase
                mv "$item" "$lowercase_path"
                ((REMOVED_COUNT++))
                echo "      ✅ Renamed: $basename_item -> $lowercase_name"
            fi
        fi
    done
}

# Find all docs directories (excluding vendor)
find "$PROJECT_ROOT" -type d -name "docs" -not -path "*/vendor/*" | while read -r docs_dir; do
    cleanup_conflicts "$docs_dir"
done

echo ""
echo "📊 Summary:"
echo "   🗑️  Files/folders removed: $REMOVED_COUNT"
echo "   🔄 Conflicts resolved: $CONFLICTS_RESOLVED"
echo ""

# Verify no more violations exist
echo "🔍 Final verification - checking for remaining violations..."
REMAINING_VIOLATIONS=0

find "$PROJECT_ROOT" -type d -name "docs" -not -path "*/vendor/*" | while read -r docs_dir; do
    find "$docs_dir" -type f -o -type d | while read -r item; do
        basename_item=$(basename "$item")
        
        # Skip docs folder itself and README.md
        if [[ "$item" == "$docs_dir" || "$basename_item" == "README.md" ]]; then
            continue
        fi
        
        if [[ "$basename_item" =~ [A-Z] ]]; then
            echo "   ⚠️  REMAINING VIOLATION: $item"
            ((REMAINING_VIOLATIONS++))
        fi
    done
done

if [[ $REMAINING_VIOLATIONS -eq 0 ]]; then
    echo "✅ All docs folders now comply with naming convention!"
else
    echo "⚠️  $REMAINING_VIOLATIONS violations still remain"
fi

echo "✨ Docs cleanup completed!"
