//Menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const barMenu = document.getElementById('barmenu');
    const primaryMenu = document.getElementById('primary-menu');
  
    menuToggle.addEventListener('click', function() {
        barMenu.classList.toggle('is-active');
        primaryMenu.classList.toggle('is-active')
    });
    const menuLinks = primaryMenu.querySelectorAll("li a");
    menuLinks.forEach(link => {
        link.addEventListener("click", function () {
            barMenu.classList.remove("is-active");
            primaryMenu.classList.remove("is-active");
        });
    });
});

//Affichage menu lors du scroll
document.addEventListener("DOMContentLoaded", function() {
    var lastScrollTop = 0;
    var navbar = document.getElementById("barmenu");

    window.addEventListener("scroll", function() {
        var currentScroll = window.scrollY || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop && currentScroll > 80) {
            // Scrolling Down
            if (!navbar.classList.contains("is-active")) {
                navbar.style.top = "-100px";
            }
        } else {
            // Scrolling Up
            navbar.style.top = "0px";
        }
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
    }, false);
});
