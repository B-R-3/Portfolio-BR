document.addEventListener("DOMContentLoaded", () => {
    // Charger dynamiquement le fichier nav.html
    fetch("../../composants/navigation/nav_main.html")
        .then(response => {
            if (!response.ok) throw new Error("Erreur de chargement du fichier nav_main.html");
            return response.text();
        })
        .then(data => {
            // Insérer la navigation directement au début du body
            const navPlaceholder = document.createElement("div");
            navPlaceholder.innerHTML = data;
            document.body.insertAdjacentElement("afterbegin", navPlaceholder); // Insérer au tout début

            // Comportement pour afficher/masquer la navbar lors du scroll 
            const nav = document.querySelector("nav");
            if (nav) {
                nav.style.position = "fixed"; // Fixer la navbar en haut
                nav.style.top = "0";
                nav.style.width = "100%";
                nav.style.zIndex = "1000"; // Assure qu'elle reste au-dessus des autres éléments
                nav.style.opacity = "0";
                nav.style.visibility = "hidden"; // Masquer initialement la navbar

                window.addEventListener("scroll", () => {
                    const scrollPosition = window.scrollY;

                    if (scrollPosition > 50) {
                        nav.style.opacity = "1"; // Affiche progressivement
                        nav.style.visibility = "visible";
                        nav.style.transition = "opacity 0.5s ease, visibility 0.5s ease";
                    } else {
                        nav.style.opacity = "0"; // Cache la navbar
                        nav.style.visibility = "hidden";
                    }
                });
            }
        })
        .catch(error => console.error("Erreur :", error));
});
