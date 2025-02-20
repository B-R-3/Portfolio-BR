document.addEventListener("DOMContentLoaded", () => {
    // Charger dynamiquement le fichier contact.html
    fetch("composants/contact/contact.html")
        .then(response => {
            if (!response.ok) throw new Error("Erreur de chargement du fichier contact.html");
            return response.text();
        })
        .then(data => {
            const contactPlaceholder = document.querySelector("#contact");
            if (contactPlaceholder) {
                contactPlaceholder.innerHTML = data;
            }
        })
        .catch(error => console.error("Erreur lors du chargement du formulaire de contact :", error));
});
