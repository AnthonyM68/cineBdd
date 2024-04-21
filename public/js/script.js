let sideNavVisible = false;
let timeoutID = null;

function toggleSideNav(show) {
    const sidenav = document.getElementById("sideNav");

    if (show) {
        sidenav.classList.remove("hidden-sideNav");
        sidenav.classList.add("show-sideNav");
        sideNavVisible = true;
    }
    clearTimeout(timeoutID);
    timeoutID = setTimeout(() => {
        if (sidenav) {
            sidenav.classList.remove("show-sideNav");
            sidenav.classList.add("hidden-sideNav");
            sideNavVisible = false;
        }
    }, 3000);

}

document.addEventListener("DOMContentLoaded", function () {
    const inputImgs = document.querySelectorAll(".inputImg");
    const imgPreviews = document.querySelectorAll(".imgPreview");
    inputImgs.forEach(function(inputImg, index) {

        inputImg.addEventListener("change", function(event) {
            const file = event.target.files[0];
            const imgPreview = imgPreviews[index]; 

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    imgPreview.src = reader.result;
                    imgPreview.classList.add("d-block");
                };
                
                reader.readAsDataURL(file);
            } else {
                imgPreview.src = "#";
                imgPreview.classList.remove("d-block");
            }
        });
    });
    const sidenav = document.getElementById("sideNav");
    // detection du passage de la souris au bords de l'écran gauche
    document.addEventListener("mouseenter", function (event) {
        if (event.clientX <= 100) {
            toggleSideNav(true);
        }
    });

    document.addEventListener("mouseleave", function (event) {
        // si la sidenav n'est pas visible on ne fais rien
        if (!sideNavVisible) return;
        // retourne taille et position de la sidenav
        const sidenavRect = sidenav.getBoundingClientRect();
        if (event.clientY <= sidenavRect.top || event.clientX > sidenavRect.right) {
            toggleSideNav(false);
        }
    });

    document.addEventListener("scroll", function () {
        // retourne taille et position de la sidenav
        const sidenavRect = sidenav.getBoundingClientRect();
        if (window.scrollY + window.innerHeight >= sidenavRect.bottom) {
            toggleSideNav(true);
        } else {
            // Vérifie si la souris est toujours dans la zone de déclenchement
            const mouseX = event.clientX;
            if (mouseX <= 100) {
                toggleSideNav(true);
            } else {
                toggleSideNav(false);
            }
        }
    });

    const form = document.getElementById('newFormMovie');
    if (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

});