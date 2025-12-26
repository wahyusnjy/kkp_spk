#!/bin/bash

# Script to add dark mode support to all remaining blade files
# This will update text colors and background colors systematically

FILES=(
    "resources/views/pages/dashboard/admin.blade.php"
    "resources/views/pages/dashboard/manager.blade.php"
    "resources/views/pages/evaluation/assessments/index.blade.php"
    "resources/views/pages/evaluation/assessments/edit.blade.php"
    "resources/views/pages/evaluation/assessments/create.blade.php"
    "resources/views/pages/evaluation/assessments/show.blade.php"
    "resources/views/pages/reports/kriteria.blade.php"
    "resources/views/pages/reports/executive-summary.blade.php"
)

# Common replacements for dark mode support
# Text colors
sed -i '' 's/text-white"/text-gray-900 dark:text-white"/g' "${FILES[@]}" 2>/dev/null
sed -i '' 's/text-gray-400"/text-gray-600 dark:text-gray-400"/g' "${FILES[@]}" 2>/dev/null
sed -i '' 's/text-gray-500"/text-gray-500 dark:text-gray-500"/g' "${FILES[@]}" 2>/dev/null

# Background colors
sed -i '' 's/bg-dark-300/bg-white dark:bg-dark-300/g' "${FILES[@]}" 2>/dev/null
sed -i '' 's/bg-dark-400/bg-gray-50 dark:bg-dark-400/g' "${FILES[@]}" 2>/dev/null
sed -i '' 's/bg-gray-800/bg-gray-100 dark:bg-gray-800/g' "${FILES[@]}" 2>/dev/null

# Border colors
sed -i '' 's/border-dark-200/border-gray-200 dark:border-dark-200/g' "${FILES[@]}" 2>/dev/null
sed -i '' 's/border-gray-700/border-gray-200 dark:border-gray-700/g' "${FILES[@]}" 2>/dev/null

echo "Dark mode support added to all files!"
