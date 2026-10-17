import { onMounted, onUnmounted } from 'vue';

/**
 * Composable que gerencia a coreografia de Scroll Reveal (60fps)
 * e o efeito Spotlight Hover nos cards premium.
 */
export function useScrollAndSpotlight() {
    let observer = null;

    const handleCardMouseMove = (event) => {
        const card = event.currentTarget;
        const rect = card.getBoundingClientRect();
        card.style.setProperty('--mouse-x', `${event.clientX - rect.left}px`);
        card.style.setProperty('--mouse-y', `${event.clientY - rect.top}px`);
    };

    onMounted(() => {
        observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            },
            { threshold: 0.1 }
        );

        document.querySelectorAll('.reveal-up, .reveal-scale').forEach((el) => {
            observer.observe(el);
        });
    });

    onUnmounted(() => {
        if (observer) {
            observer.disconnect();
        }
    });

    return {
        handleCardMouseMove,
    };
}
