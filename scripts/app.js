window.addEventListener("scroll", function () {
    var scrollPosition = window.scrollY;
    var image1 = document.getElementById("B");
    var image2 = document.getElementById("R");
    const fleche = document.getElementById("fleche");
    
    var opacity = 1 - scrollPosition / 900;

    var separation = scrollPosition / 2;

    var delayInMilliseconds = 1000; //1 second

    setTimeout(function () {
        if (scrollPosition > 100) {
            fleche.classList.add('hidden');

        } else {
            fleche.classList.remove('hidden');
        }
    }, delayInMilliseconds);



    if (separation < 600) {
        image1.style.opacity = opacity;
        image2.style.opacity = opacity;
        fleche.style.opacity = opacity;

        fleche.style.transition = "5s ease-in-out 0s";
        image1.style.transform = "translateX(-" + separation + "px)";
        image2.style.transform = "translateX(" + separation + "px)";
    }

    if (separation > 300) {
        image1.style.opacity = opacity;
        image2.style.opacity = opacity;
        fleche.style.opacity = opacity;
    }

});
// code pour bounce de la flèche
document.addEventListener("DOMContentLoaded", () => {
    const fleche = document.getElementById("fleche");

    // Fonction pour masquer la flèche
    const hideFleche = () => {
        fleche.classList.add("hidden"); // Appliquer la classe CSS "hidden"
    };

    // Masquer la flèche après un clic
    fleche.addEventListener("click", () => {
        hideFleche();
    });

    // Masquer la flèche après un défilement
    window.addEventListener("scroll", () => {
        if (window.scrollY > 0) {
            hideFleche();
        }
    });
});



function showTimeline(timelineType) {
    const scolaireTimeline = document.getElementById('timeline-scolaire');
    const proTimeline = document.getElementById('timeline-pro');
    scolaireTimeline.style.opacity = 0;
    proTimeline.style.opacity = 0;

    if (timelineType === 'scolaire') {
        scolaireTimeline.classList.remove('hidden');
        proTimeline.style.transition = "1s";
        proTimeline.style.opacity = 1;
    } else if (timelineType === 'pro') {
        proTimeline.classList.remove('hidden');
        scolaireTimeline.style.transition = "1s";
        scolaireTimeline.style.opacity = 1;

    }
}