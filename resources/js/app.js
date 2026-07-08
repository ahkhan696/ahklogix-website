import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);

window.Alpine = Alpine;
Alpine.start();

// Load canvas only when the hero element is present (home page only)
if (document.getElementById('hero-bg')) {
    import('./canvas-network.js');
}
