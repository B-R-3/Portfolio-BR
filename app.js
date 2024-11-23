window.addEventListener("scroll", function() {
    var scrollPosition = window.scrollY;
    var nav = document.querySelector("nav");

    // Calculez une valeur d'opacité en fonction de la position de défilement
    var opacity = Math.min(1, scrollPosition / 1000);

    // Appliquez l'opacité à la navigation
    nav.style.opacity = opacity;

    // Ajoutez ou supprimez la classe "black" en fonction de la position de défilement
    if (scrollPosition > 350) {
        nav.classList.add("black");
    } else {
        nav.classList.remove("black");
    }
});

window.addEventListener("scroll", function() {
    var scrollPosition = window.scrollY;
    var image1 = document.getElementById("B");
    var image2 = document.getElementById("R");

    var opacity = 1 - scrollPosition / 900;

    var separation = scrollPosition / 2; 


    if (separation<600) {
        console.log("opacity", opacity)
        image1.style.opacity = opacity;
        image2.style.opacity = opacity;
        
        image1.style.transform = "translateX(-" + separation + "px)";
        image2.style.transform = "translateX(" + separation + "px)";
        console.log(separation);
    } 

    if (separation>300) {
        image1.style.opacity = opacity;
        image2.style.opacity = opacity;
    }
        
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
var modal = document.getElementById("myModal");
                var modalImg = document.getElementById("modalImage");
                var span = document.getElementsByClassName("close")[0];

                // Lorsque l'utilisateur clique sur une cellule avec une image
                document.querySelectorAll('.image-cell').forEach(function (cell) {
                    cell.addEventListener('click', function () {
                        var imgSrc = this.getAttribute('data-image');
                        modalImg.src = imgSrc;
                        modal.style.display = "block";
                    });
                });

                // Lorsque l'utilisateur clique sur la croix pour fermer
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // Lorsque l'utilisateur clique n'importe où en dehors du modal, fermer le modal
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }