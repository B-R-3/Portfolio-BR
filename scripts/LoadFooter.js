document.addEventListener("DOMContentLoaded", () => {
    // Charger dynamiquement le fichier footer.html
    fetch("../../composants/footer/footer.html")
        .then(response => {
            if (!response.ok) throw new Error("Erreur de chargement du fichier footer.html");
            return response.text();
        })
        .then(data => {
            const footerPlaceholder = document.querySelector("#footer-container");
            if (footerPlaceholder) {
                footerPlaceholder.innerHTML = data;
            }
        })
        .catch(error => console.error("Erreur lors du chargement du footer :", error));
});
