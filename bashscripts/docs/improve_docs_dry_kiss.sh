#!/bin/bash

# Script to analyze and improve documentation following DRY and KISS principles
# This script will identify redundancies, outdated content, and improvement opportunities

PROJECT_ROOT="/var/www/html/_bases/base_techplanner_fila3_mono"
ANALYSIS_FILE="$PROJECT_ROOT/bashscripts/docs/docs_analysis_report.md"
IMPROVEMENT_LOG="$PROJECT_ROOT/bashscripts/docs/docs_improvement_log.md"

echo "📚 Starting comprehensive documentation analysis and improvement..."
echo "🎯 Applying DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles"
echo ""

# Create analysis report header
cat > "$ANALYSIS_FILE" << 'EOF'
# Documentation Analysis Report

Generated: $(date)

## Overview

This report analyzes all documentation in the project to identify:
- Redundant content (violates DRY)
- Overly complex explanations (violates KISS)
- Outdated information
- Missing documentation
- Inconsistent formatting

## Analysis Results

EOF

# Create improvement log header
cat > "$IMPROVEMENT_LOG" << 'EOF'
# Documentation Improvement Log

Generated: $(date)

## Improvements Applied

This log tracks all improvements made to documentation following DRY and KISS principles.

EOF

# Function to analyze a docs folder
analyze_docs_folder() {
    local docs_path="$1"
    local module_name=$(echo "$docs_path" | sed 's|.*/Modules/\([^/]*\)/.*|\1|' | sed 's|.*/\([^/]*\)/docs.*|\1|')
    
    echo "📁 Analyzing: $docs_path ($module_name)"
    
    # Count files
    local file_count=$(find "$docs_path" -name "*.md" -o -name "*.mdc" | wc -l)
    
    # Check for common redundant files
    local readme_count=$(find "$docs_path" -iname "readme*" | wc -l)
    local index_count=$(find "$docs_path" -iname "index*" | wc -l)
    
    # Add to analysis report
    cat >> "$ANALYSIS_FILE" << EOF

### $module_name Module
- **Path**: $docs_path
- **Total files**: $file_count
- **README files**: $readme_count
- **Index files**: $index_count

EOF

    # Check for potential redundancies
    if [[ $readme_count -gt 1 ]]; then
        echo "   ⚠️  Multiple README files found - potential redundancy"
        echo "- **Issue**: Multiple README files detected" >> "$ANALYSIS_FILE"
    fi
    
    if [[ $index_count -gt 1 ]]; then
        echo "   ⚠️  Multiple index files found - potential redundancy"
        echo "- **Issue**: Multiple index files detected" >> "$ANALYSIS_FILE"
    fi
    
    # Look for duplicate content patterns
    find "$docs_path" -name "*.md" -o -name "*.mdc" | while read -r file; do
        # Check for very short files (potentially incomplete)
        local size=$(stat -c%s "$file" 2>/dev/null || echo 0)
        if [[ $size -lt 100 ]]; then
            echo "   📝 Very short file: $(basename "$file") ($size bytes)"
            echo "- **Short file**: $(basename "$file") ($size bytes)" >> "$ANALYSIS_FILE"
        fi
        
        # Check for files with similar names (potential duplicates)
        local basename_file=$(basename "$file" .md | tr '[:upper:]' '[:lower:]')
        local similar_files=$(find "$docs_path" -name "*.md" -o -name "*.mdc" | grep -i "$basename_file" | wc -l)
        if [[ $similar_files -gt 1 ]]; then
            echo "   🔄 Potential duplicate content: $(basename "$file")"
            echo "- **Potential duplicate**: $(basename "$file")" >> "$ANALYSIS_FILE"
        fi
    done
}

# Analyze main project docs folders (excluding vendor)
echo "🔍 Analyzing project documentation folders..."

# Main docs
if [[ -d "$PROJECT_ROOT/docs" ]]; then
    analyze_docs_folder "$PROJECT_ROOT/docs"
fi

# Bashscripts docs
if [[ -d "$PROJECT_ROOT/bashscripts/docs" ]]; then
    analyze_docs_folder "$PROJECT_ROOT/bashscripts/docs"
fi

# Module docs
find "$PROJECT_ROOT/laravel/Modules" -type d -name "docs" -not -path "*/vendor/*" | while read -r docs_dir; do
    analyze_docs_folder "$docs_dir"
done

# Theme docs
find "$PROJECT_ROOT/laravel/Themes" -type d -name "docs" | while read -r docs_dir; do
    analyze_docs_folder "$docs_dir"
done

# Generate summary
cat >> "$ANALYSIS_FILE" << 'EOF'

## Recommendations

### DRY Principle Violations
- Consolidate multiple README files into a single authoritative source
- Merge duplicate content across similar files
- Create shared documentation templates

### KISS Principle Improvements
- Simplify overly complex explanations
- Break down large documents into focused topics
- Use clear, concise language
- Implement consistent formatting

### Action Items
1. Identify and merge redundant documentation
2. Standardize documentation structure across modules
3. Create master index/navigation
4. Implement documentation templates
5. Regular documentation reviews

EOF

echo ""
echo "📊 Analysis complete! Reports generated:"
echo "   📄 Analysis Report: $ANALYSIS_FILE"
echo "   📝 Improvement Log: $IMPROVEMENT_LOG"
echo ""
echo "🎯 Next steps:"
echo "   1. Review analysis report"
echo "   2. Apply DRY/KISS improvements"
echo "   3. Standardize documentation structure"
echo "   4. Create unified navigation"
echo ""
echo "✨ Documentation improvement analysis completed!"
