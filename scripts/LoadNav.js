document.addEventListener("DOMContentLoaded", () => {
    // Charger dynamiquement le fichier nav.html
    const navPath = window.location.pathname.includes("pages/")
    ? "../../composants/navigation/nav_main.html"
    : "composants/navigation/nav_main.html";

fetch(navPath)

        .then(response => {
            if (!response.ok) throw new Error("Erreur de chargement du fichier nav_main.html");
            return response.text();
        })
        .then(data => {
            // Insérer la navigation directement au début du body
            const navPlaceholder = document.createElement("div");
            navPlaceholder.innerHTML = data;
            document.body.insertAdjacentElement("afterbegin", navPlaceholder);

            // Comportement pour afficher/masquer la navbar lors du scroll
            const nav = document.querySelector("nav");
            if (nav) {
                nav.style.position = "fixed";
                nav.style.top = "0";
                nav.style.width = "100%";
                nav.style.zIndex = "1000";
                nav.style.opacity = "0";
                nav.style.visibility = "hidden";

                window.addEventListener("scroll", () => {
                    const scrollPosition = window.scrollY;

                    if (scrollPosition > 50) {
                        nav.style.opacity = "1";
                        nav.style.visibility = "visible";
                        nav.style.transition = "opacity 0.5s ease, visibility 0.5s ease";
                    } else {
                        nav.style.opacity = "0";
                        nav.style.visibility = "hidden";
                    }
                });
            }
        })
        .catch(error => console.error("Erreur :", error));
});
