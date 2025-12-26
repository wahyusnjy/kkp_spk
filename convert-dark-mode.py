#!/usr/bin/env python3
"""
Dark Mode Converter for Blade Files
Updates blade templates to support light/dark mode
"""

import re
import glob
import os

# Files to update
TARGET_FILES = [
    "resources/views/pages/dashboard/admin.blade.php",
    "resources/views/pages/dashboard/manager.blade.php",
    "resources/views/pages/evaluation/assessments/index.blade.php",
    "resources/views/pages/evaluation/assessments/edit.blade.php",
    "resources/views/pages/evaluation/assessments/create.blade.php",
    "resources/views/pages/evaluation/assessments/show.blade.php",
    "resources/views/pages/reports/kriteria.blade.php",
    "resources/views/pages/reports/executive-summary.blade.php",
]

# Replacement patterns
REPLACEMENTS = [
    # Text colors - only replace standalone text-white without dark: prefix
    (r'class="([^"]*)\btext-white\b(?!\s)', r'class="\1text-gray-900 dark:text-white'),
    (r'class="([^"]*)\btext-gray-400\b(?!\s)', r'class="\1text-gray-600 dark:text-gray-400'),
    
    # Background colors
    (r'\bbg-dark-300\b(?!.*dark:)', r'bg-white dark:bg-dark-300'),
    (r'\bbg-dark-400\b(?!.*dark:)', r'bg-gray-50 dark:bg-dark-400'),
    (r'\bbg-gray-800\b(?!.*dark:)', r'bg-gray-100 dark:bg-gray-800'),
    
    # Border colors
    (r'\bborder-dark-200\b(?!.*dark:)', r'border-gray-200 dark:border-dark-200'),
    (r'\bborder-gray-700\b(?!.*dark:)', r'border-gray-200 dark:border-gray-700'),
    
    # Divide colors
    (r'\bdivide-dark-200\b(?!.*dark:)', r'divide-gray-200 dark:divide-dark-200'),
    (r'\bdivide-gray-700\b(?!.*dark:)', r'divide-gray-200 dark:divide-gray-700'),
    
    # Hover states
    (r'\bhover:bg-dark-400\b(?!.*dark:)', r'hover:bg-gray-100 dark:hover:bg-dark-400'),
    (r'\bhover:bg-dark-200\b(?!.*dark:)', r'hover:bg-gray-200 dark:hover:bg-dark-200'),
    (r'\bhover:bg-gray-700\b(?!.*dark:)', r'hover:bg-gray-200 dark:hover:bg-gray-700'),
]

def update_file(filepath):
    """Update a single file with dark mode classes"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        
        # Apply all replacements
        for pattern, replacement in REPLACEMENTS:
            content = re.sub(pattern, replacement, content)
        
        # Only write if content changed
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        return False
    except FileNotFoundError:
        print(f"⚠️  File not found: {filepath}")
        return False
    except Exception as e:
        print(f"❌ Error processing {filepath}: {e}")
        return False

def main():
    """Main function"""
    print("🌓 Dark Mode Converter for Blade Files")
    print("=" * 50)
    
    updated_count = 0
    skipped_count = 0
    
    for filepath in TARGET_FILES:
        full_path = os.path.join(os.getcwd(), filepath)
        print(f"\n📄 Processing: {filepath}")
        
        if update_file(full_path):
            print(f"   ✅ Updated successfully")
            updated_count += 1
        else:
            print(f"   ⏭️  Skipped (no changes or file not found)")
            skipped_count += 1
    
    print("\n" + "=" * 50)
    print(f"✨ Done! Updated {updated_count} files, skipped {skipped_count} files")

if __name__ == "__main__":
    main()
