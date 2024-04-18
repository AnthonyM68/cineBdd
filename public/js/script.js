let sideNavVisible = false;
let timeoutID = null;

function isMouseAtLeftEdge(event) {
    const mouseX = event.clientX;
    const triggerDistance = 100;

    return mouseX <= triggerDistance;
}

function toggleSideNav() {
    // If an instance of setTimout is already in progress
    if (timeoutID !== null) {
        // we cancel it
        clearTimeout(timeoutID);
    }
    const sidenav = document.getElementById("sideNav");
    if (sideNavVisible) {
        sidenav.classList.add("hidden-sideNav");
        sideNavVisible = false;
    } else {
        sidenav.classList.remove("hidden-sideNav");
        sideNavVisible = true;
        // New instance of setTimout
        timeoutID = setTimeout(() => {
            toggleSideNav();
            timeoutID = null;
        }, 3000);
    }

}


document.addEventListener("DOMContentLoaded", function () {

   /* document.addEventListener("mousemove", function (event) {
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
    const sidenav = document.getElementById("sideNav");*/
    document.addEventListener("scroll", function () {
        const scrollPosition = container.scrollTop;

        if (scrollPosition) {
            if (sidenav) sidenav.classList.add("show-sideNav");
            sideNavVisible = false;
        }
        else {
            if (sidenav) {
                sidenav.classList.remove("show-sideNav");
                sidenav.classList.add("hidden-sideNav");
                sideNavVisible = true;
                // New instance of setTimout
                timeoutID = setTimeout(() => {
                    toggleSideNav();
                    timeoutID = null;
                }, 3000);
            }
        }
    });
});