document.addEventListener("DOMContentLoaded", function () {

    // Select all elements that use your EXISTING animation classes
    const animatedElements = document.querySelectorAll(
        ".fade-up, .zoom-in, .animate-section"
    );

    // Fallback for very old browsers
    if (!("IntersectionObserver" in window)) {
        animatedElements.forEach(el => el.classList.add("animated"));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animated");
                    obs.unobserve(entry.target); // animate only once
                }
            });
        },
        {
            threshold: 0.15,
            rootMargin: "0px 0px -80px 0px"
        }
    );

    animatedElements.forEach(el => observer.observe(el));
});




