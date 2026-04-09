import './bootstrap';
// 1. Core library setup (if needed globally for the Livewire wrapper)
import Sortable from 'sortablejs';
window.Sortable = Sortable;

// 2. Load the Livewire Sortable plugin
// This is the line the documentation asks for:
import 'livewire-sortable';

// 3. EasyMDE Markdown Editor
import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css';

window.initMarkdownEditor = function(selector, livewireComponent, livewireProperty) {
    const textarea = document.querySelector(selector);
    if (!textarea || textarea._easymde) return;

    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

    const editor = new EasyMDE({
        element: textarea,
        spellChecker: false,
        autoDownloadFontAwesome: false,
        status: false,
        minHeight: '200px',
        placeholder: 'Write with markdown...',
        toolbar: [
            'bold', 'italic', 'strikethrough', '|',
            'heading-1', 'heading-2', 'heading-3', '|',
            'unordered-list', 'ordered-list', 'table', '|',
            'link', 'horizontal-rule', '|',
            'preview', 'side-by-side', '|',
            'guide'
        ],
        shortcuts: {
            'toggleFullScreen': null,
        },
    });

    // Sync editor → Livewire on every change
    editor.codemirror.on('change', function() {
        livewireComponent.set(livewireProperty, editor.value());
    });

    textarea._easymde = editor;
    return editor;
};