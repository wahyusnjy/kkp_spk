# Dark/Light Mode Toggle - Dokumentasi

## 📋 Overview
Sistem dark/light mode telah diimplementasikan untuk seluruh halaman aplikasi dengan **dark mode sebagai default**.

## ✨ Fitur Utama

### 1. **Default Dark Mode**
- Aplikasi akan langsung load dengan dark mode saat pertama kali dibuka
- Preferensi user disimpan di localStorage browser

### 2. **Toggle Button Locations**

#### Desktop (Sidebar)
- Tombol toggle terletak di bagian bawah sidebar
- Di atas menu logout
- Icon: Sun (☀️) untuk light mode, Moon (🌙) untuk dark mode

#### Mobile (Header)
- Tombol toggle terletak di header mobile
- Sebelah kiri dropdown user menu
- Format: Icon button dengan size lebih kecil

#### Auth Pages (Login/Register)
- Floating button di pojok kanan atas
- Shadow dan hover effect untuk UX yang lebih baik

### 3. **Persistent Storage**
- Preferensi theme disimpan di `localStorage`
- Key: `theme`
- Value: `'dark'` atau `'light'`
- Theme akan tetap sama meski user reload halaman atau logout/login

## 🎨 Implementasi Detail

### Files Modified

1. **JavaScript Module**
   - `resources/js/theme-toggle.js` - Core theme toggle logic
   - `resources/js/app.js` - Import theme module

2. **Layouts**
   - `resources/views/components/layouts/app/sidebar.blade.php`
     - Theme initialization script
     - Toggle button di sidebar (desktop)
     - Toggle button di header (mobile)
   
   - `resources/views/components/layouts/auth/simple.blade.php`
     - Theme initialization script
     - Floating toggle button
     - Enhanced gradient backgrounds untuk light/dark mode

### CSS Classes
Aplikasi menggunakan Tailwind CSS dengan dark mode variant:
```css
/* Light Mode */
bg-white text-gray-900

/* Dark Mode */
dark:bg-zinc-800 dark:text-white
```

## 🔧 Cara Menggunakan

### User Perspective
1. Klik tombol toggle theme (icon sun/moon)
2. Theme akan langsung berubah
3. Preferensi tersimpan otomatis

### Developer Perspective

#### Menambahkan Dark Mode ke Element Baru
```html
<!-- Background -->
<div class="bg-white dark:bg-zinc-800">
    Content
</div>

<!-- Text -->
<p class="text-gray-900 dark:text-white">
    Text content
</p>

<!-- Border -->
<div class="border-gray-200 dark:border-zinc-700">
    Content
</div>
```

#### Mengakses Theme via JavaScript
```javascript
// Get current theme
const currentTheme = localStorage.getItem('theme') || 'dark';

// Set theme programmatically
window.applyTheme('dark');  // or 'light'

// Toggle theme
window.toggleTheme();
```

## 🎯 Default Theme Logic

```javascript
// Priority order:
1. localStorage value (if exists)
2. Default: 'dark'

// Code:
const savedTheme = localStorage.getItem('theme') || 'dark';
```

## 🔄 Theme Application Flow

1. **Page Load**
   - Inline script runs immediately (prevent flash)
   - Read from localStorage
   - Apply dark class to `<html>` element

2. **User Toggles Theme**
   - Click event detected
   - Theme switched (dark ↔ light)
   - localStorage updated
   - Button icons updated

3. **Page Navigation**
   - Livewire navigation preserves theme
   - Standard navigation re-reads from localStorage

## 🌈 Color Scheme

### Light Mode
- Background: White, Gray-50
- Text: Gray-900, Gray-700
- Accents: Blue-600

### Dark Mode  
- Background: Zinc-800, Zinc-900
- Text: White, Gray-200
- Accents: Blue-500

## ✅ Testing Checklist

- [x] Desktop sidebar toggle works
- [x] Mobile header toggle works
- [x] Auth page toggle works
- [x] Theme persists on page reload
- [x] Theme persists after logout/login
- [x] No flash of unstyled content (FOUC)
- [x] All pages support dark mode
- [x] Icons update correctly

## 🚀 Future Enhancements

Possible improvements:
- [ ] System theme detection (auto match OS preference)
- [ ] Smooth transition animations
- [ ] Per-page theme overrides
- [ ] Theme customization (custom colors)
- [ ] Keyboard shortcut (e.g., Ctrl+Shift+D)

## 📝 Notes

- Theme preference is **browser-specific** (not synced across devices)
- Clearing browser data will reset theme to default (dark)
- Compatible with all modern browsers (localStorage support required)
