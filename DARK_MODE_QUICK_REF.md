# Quick Reference: Dark Mode Classes

## Common Patterns

### Backgrounds
```blade
<!-- Container -->
bg-white dark:bg-zinc-900
bg-gray-50 dark:bg-zinc-800
bg-gray-100 dark:bg-gray-800

<!-- Cards -->
bg-white dark:bg-dark-300
bg-gray-50 dark:bg-dark-400
```

### Text Colors
```blade
<!-- Headings -->
text-gray-900 dark:text-white

<!-- Body Text -->
text-gray-600 dark:text-gray-400

<!-- Muted Text -->
text-gray-500 dark:text-gray-500
```

### Borders
```blade
border-gray-200 dark:border-zinc-700
border-gray-200 dark:border-dark-200
divide-gray-200 dark:divide-zinc-700
```

### Hover States
```blade
hover:bg-gray-50 dark:hover:bg-zinc-800/50
hover:bg-gray-100 dark:hover:bg-dark-400
hover:text-gray-900 dark:hover:text-white
```

### Tables
```blade
<!-- Table Container -->
<div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700">

<!-- Table Header -->
<thead class="bg-gray-50 dark:bg-zinc-800">

<!-- Table Row -->
<tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">

<!-- Table Cell -->
<td class="text-gray-900 dark:text-white">
```

### Forms
```blade
<!-- Input -->
<input class="bg-white dark:bg-dark-400 border-gray-300 dark:border-dark-200 text-gray-900 dark:text-white">

<!-- Label -->
<label class="text-gray-700 dark:text-gray-300">
```

### Buttons
```blade
<!-- Primary stays same (blue gradient) -->
<button class="bg-blue-600 hover:bg-blue-700 text-white">

<!-- Secondary -->
<button class="bg-gray-200 dark:bg-zinc-700 text-gray-900 dark:text-white">
```

## JavaScript Access

```javascript
// Get current theme
const theme = localStorage.getItem('theme') || 'dark';

// Toggle
window.toggleTheme();

// Set specific
window.applyTheme('dark');
window.applyTheme('light');
```

## SweetAlert2

```javascript
Swal.fire({
    background: localStorage.getItem('theme') === 'dark' ? '#1f2937' : '#ffffff',
    color: localStorage.getItem('theme') === 'dark' ? '#fff' : '#000'
});
```
