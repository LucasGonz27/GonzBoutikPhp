document.addEventListener("DOMContentLoaded", function () {
  // Sélection des éléments
  const track = document.querySelector(".carousel-track");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  const products = document.querySelectorAll(".product");
  const productWidth = products[0].offsetWidth + 20; // Largeur + marge
  const visibleProducts = 2; // Nombre de produits visibles
  let index = 0;
  let totalProducts = products.length;

  // Déplacer le carrousel d'un produit à la fois
  function moveCarousel(direction) {
    if (direction === "next") {
      index++;
      track.style.transition = "transform 0.5s ease-in-out";
      track.style.transform = `translateX(-${index * productWidth}px)`;

      if (index >= totalProducts - visibleProducts) {
        setTimeout(() => {
          track.style.transition = "none";
          index = 0;
          track.style.transform = `translateX(0)`;
        }, 500);
      }
    } else if (direction === "prev") {
      if (index <= 0) {
        track.style.transition = "none";
        index = totalProducts - visibleProducts;
        track.style.transform = `translateX(-${index * productWidth}px)`;
      }

      setTimeout(() => {
        track.style.transition = "transform 0.5s ease-in-out";
        index--;
        track.style.transform = `translateX(-${index * productWidth}px)`;
      }, 50);
    }
  }

  // Ajouter les événements aux boutons
  nextBtn.addEventListener("click", () => moveCarousel("next"));
  prevBtn.addEventListener("click", () => moveCarousel("prev"));

  // Gestion du menu burger
  const menuToggle = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const closeMenu = document.getElementById("closeMenu");
  const overlay = document.createElement("div"); // Crée un fond d'écran overlay
  overlay.classList.add("menu-overlay");
  document.body.appendChild(overlay);

  const searchIcon = document.querySelector(".search-icon");
  const closeSearch = document.getElementById("closeSearch");
  const body = document.body;
  let isSearchOpen = false;

  searchIcon.addEventListener("click", function (event) {
    event.stopPropagation();
    isSearchOpen = true;
    body.classList.add("no-scroll");
  });

  // Fermer la recherche et réactiver le scroll quand on clique sur le bouton de fermeture
  closeSearch.addEventListener("click", function () {
    isSearchOpen = false;
    body.classList.remove("no-scroll");
  });

  // Fermer aussi si on clique en dehors de la recherche
  document.addEventListener("click", function (event) {
    if (
      isSearchOpen &&
      !event.target.closest(".search-box") &&
      !event.target.closest(".search-icon")
    ) {
      isSearchOpen = false;
      body.classList.remove("no-scroll");
    }
  });

  // Quand on clique ailleurs sur la page, fermer la recherche et réactiver le scroll
  document.addEventListener("click", function (event) {
    if (
      isSearchOpen &&
      !event.target.closest(".search-box") &&
      !event.target.closest(".search-icon")
    ) {
      isSearchOpen = false;
      body.classList.remove("no-scroll");
    }
  });

  // Ouvrir et fermer le menu burger
  menuToggle.addEventListener("click", function () {
    document.body.classList.toggle("menu-open");

    if (mobileMenu.style.display === "block") {
      mobileMenu.style.display = "none";
      overlay.style.display = "none";
    } else {
      mobileMenu.style.display = "block";
      overlay.style.display = "block"; // Affiche l'overlay
    }
  });

  // Fermer le menu avec la croix
  closeMenu.addEventListener("click", function () {
    mobileMenu.style.display = "none";
    overlay.style.display = "none";
    document.body.classList.remove("menu-open");
  });

  // Fermer le menu en cliquant sur le fond blanc
  overlay.addEventListener("click", function () {
    mobileMenu.style.display = "none";
    overlay.style.display = "none";
    document.body.classList.remove("menu-open");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Sélection des éléments pour la recherche
  const searchIcon = document.querySelector(".search-icon");
  const searchOverlay = document.getElementById("searchOverlay");
  const closeSearch = document.getElementById("closeSearch");

  // Ouvrir la recherche
  searchIcon.addEventListener("click", function () {
    searchOverlay.style.display = "flex"; // Affiche le menu de recherche
    document.body.classList.add("blurred"); // Ajoute un effet de flou (si besoin)
  });

  // Fermer la recherche
  closeSearch.addEventListener("click", function () {
    searchOverlay.style.display = "none"; // Cache le menu de recherche
    document.body.classList.remove("blurred");
  });

  // Fermer si on clique en dehors de la recherche
  searchOverlay.addEventListener("click", function (event) {
    if (!event.target.closest(".search-container")) {
      searchOverlay.style.display = "none";
      document.body.classList.remove("blurred");
    }
  });
});


