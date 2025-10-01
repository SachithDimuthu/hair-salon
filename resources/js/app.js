import './bootstrap';

// Import AlpineJS
import Alpine from 'alpinejs';

// Make Alpine available globally for Livewire
window.Alpine = Alpine;

// DON'T start Alpine manually - let Livewire handle it
// Alpine.start(); // <-- This line causes conflicts with Livewire

// Note: Livewire will automatically start Alpine when it initializes
// Cache bust comment: v2.0 - Fixed Alpine conflicts
