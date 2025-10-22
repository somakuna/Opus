import './bootstrap';
// 1. Core library setup (if needed globally for the Livewire wrapper)
import Sortable from 'sortablejs';
window.Sortable = Sortable;

// 2. Load the Livewire Sortable plugin
// This is the line the documentation asks for:
import 'livewire-sortable';