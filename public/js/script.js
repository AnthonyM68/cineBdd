let sideNavVisible = false;
let timeoutID = null;

function isMouseAtLeftEdge(event) {
    const mouseX = event.clientX;
    const triggerDistance = 100;

    return mouseX <= triggerDistance;
}

function toggleSideNav() {
    // Si une instance de setTimout est déjà en cours
    if (timeoutID !== null) {
        // on l'annule
        clearTimeout(timeoutID);
    }
    const sidenav = document.getElementById("sideNav");
    if (sideNavVisible) {
        sidenav.classList.add("hidden-sideNav");
        sideNavVisible = false;
    } else {
        sidenav.classList.remove("hidden-sideNav");
        sideNavVisible = true;
        // Nouvelle instance de setTimout
        timeoutID = setTimeout(() => {
            toggleSideNav();
            timeoutID = null;
        }, 3000);
    }

}
document.addEventListener("DOMContentLoaded", function () {

    document.addEventListener("mousemove", function (event) {
        const sidenav = document.getElementById("sideNav");
        if (isMouseAtLeftEdge(event)) {
            if (sidenav) sidenav.classList.add("show-sideNav");
        }
        else {
            if (sidenav) {
                sidenav.classList.remove("show-sideNav");
                sidenav.classList.add("hidden-sideNav");
            }
        }
    });
    const container = document.querySelector(".container");
    document.addEventListener("scroll", function () {
        const scrollPosition = container.scrollTop;
        if (scrollPosition) {
            toggleSideNav();
        } else {
            if (!sideNavVisible) {
                toggleSideNav();
            }
        }
    });
});
