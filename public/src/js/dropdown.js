// JavaScript pour la fonctionnalité du menu déroulant
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne le bouton qui déclenche le menu déroulant
    const dropdownButton = document.getElementById('materielsBtn');
    // Sélectionne le menu déroulant
    const dropdownMenu = document.getElementById('dropdownMenu');
  
    // Ajoute un écouteur d'événement au clic sur le bouton
    dropdownButton.addEventListener('click', function(event) {
      // Empêche la propagation de l'événement vers le document
      event.stopPropagation();
      // Toggle la classe "show" pour afficher/masquer le menu
      dropdownMenu.classList.toggle('show');
    });
  
    // Ajoute un écouteur d'événement au clic sur le document
    document.addEventListener('click', function(event) {
      // Si le clic n'est ni sur le menu ni sur le bouton, ferme le menu
      if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
  });
  