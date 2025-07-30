export default {
    mounted(el, binding) {
        el.classList.add('before-enter');
        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                el.classList.add('enter');
                observer.unobserve(el);
            }
        }, {
            threshold: 0.2
        });

        observer.observe(el);
    }
};