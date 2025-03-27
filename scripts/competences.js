// -----------------------Tableau des competences------------------------------- 
var imageModal = document.getElementById("imageModal");
var descriptionModal = document.getElementById("descriptionModal");
var modalImg = document.getElementById("modalImage");

// Lorsque l'utilisateur clique sur une cellule avec une image
document.querySelectorAll('.image-cell').forEach(function (cell) {
    cell.addEventListener('click', function () {
        var imgSrc = this.getAttribute('data-image');
        modalImg.src = imgSrc;
        imageModal.style.display = "block";
    });
});

// Lorsque l'utilisateur clique sur la croix pour fermer
document.querySelectorAll('.close').forEach(function(closeBtn) {
    closeBtn.onclick = function () {
        imageModal.style.display = "none";
        descriptionModal.style.display = "none";
    }
});

// Lorsque l'utilisateur clique n'importe où en dehors du modal, fermer le modal
window.onclick = function (event) {
    if (event.target == imageModal) {
        imageModal.style.display = "none";
    }
    if (event.target == descriptionModal) {
        descriptionModal.style.display = "none";
    }
}

// -------------------------Tableau blocs--------------------------------------
// Ajouter un événement pour chaque lien "En savoir plus"
document.querySelectorAll('.card__button').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        var description = this.getAttribute('data-description'); // Récupère le contenu HTML du data-description
        document.querySelector("#descriptionModal .modal-content").innerHTML = `
            <span class="close">&times;</span>
            ${description}
        `; // Insère le contenu dans le modal
        descriptionModal.style.display = "block"; // Affiche le modal
    });
});

