// -----------------------Tableau des competences------------------------------- 
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





// -------------------------Tableau blocs--------------------------------------
// Récupération des éléments
// Récupération des éléments
var modal = document.getElementById("myModal");
var modalContent = document.querySelector(".modal-content");

// Ajouter un événement pour chaque lien "En savoir plus"
document.querySelectorAll('.card__button').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        var description = this.getAttribute('data-description'); // Récupère le contenu HTML du data-description
        modalContent.innerHTML = `
            <span class="close">&times;</span>
            ${description}
        `; // Insère le contenu dans le modal
        modal.style.display = "block"; // Affiche le modal

        // Ajouter un événement pour fermer le modal (après la réinjection du contenu)
        document.querySelector(".close").onclick = function() {
            modal.style.display = "none";
        };
    });
});

// Fermer le modal en cliquant en dehors de celui-ci
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

