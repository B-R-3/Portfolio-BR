document.addEventListener("DOMContentLoaded", () => {
    // Détermine si on est dans un sous-dossier
    const navPath = window.location.pathname.includes("pages/")
        ? "../../composants/navigation/nav_main.html"
        : "composants/navigation/nav_main.html";

    fetch(navPath)
        .then(response => {
            if (!response.ok) throw new Error("Erreur de chargement du fichier nav_main.html");
            return response.text();
        })
        .then(data => {
            // Insérer la navbar dynamiquement
            const navPlaceholder = document.createElement("div");
            navPlaceholder.innerHTML = data;
            document.body.insertAdjacentElement("afterbegin", navPlaceholder);

            const nav = document.querySelector("nav");

            if (nav) {
                // Détecter la page actuelle
                let page = window.location.pathname.split("/").pop(); // Récupère le nom du fichier

                if (page === "index.html") { 
                    // 🚀 Si on est sur index.html, la navbar apparaît après le scroll
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

                } else {
                    // 🚀 Navbar fixe pour toutes les autres pages
                    nav.classList.add("navbar-fixed"); 
                    nav.style.opacity = "1";
                    nav.style.visibility = "visible";
                }
            }
        })
        .catch(error => console.error("Erreur :", error));
});
