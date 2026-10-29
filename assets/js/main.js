/* 
  File: assets/js/main.js
  Keterangan: Handle animasi scroll dan pop-up interaktif website.
*/

document.addEventListener("DOMContentLoaded", function() {
    // Fungsi Animasi Scroll Reveal
    function revealOnScroll() {
        const reveals = document.querySelectorAll(".reveal");
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add("active");
            }
        });
    }

    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll(); // Trigger saat load awal
});