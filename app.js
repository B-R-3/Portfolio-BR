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

    
    var separation = scrollPosition / 5; 

    
    image1.style.transform = "translateX(-" + separation + "px)";
    image2.style.transform = "translateX(" + separation + "px)";
});
function showTimeline(timelineType) {
    const scolaireTimeline = document.getElementById('timeline-scolaire');
    const proTimeline = document.getElementById('timeline-pro');

    if (timelineType === 'scolaire') {
        scolaireTimeline.classList.remove('hidden');
        proTimeline.classList.add('hidden');
    } else if (timelineType === 'pro') {
        proTimeline.classList.remove('hidden');
        scolaireTimeline.classList.add('hidden');
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