document.addEventListener('DOMContentLoaded', function() {
  const dropdownBtn = document.querySelector('.dropdown-btn');
  const dropdownContent = document.querySelector('.dropdown-content');
  
  dropdownBtn.addEventListener('click', function() {
      dropdownContent.classList.toggle('show');
  });
  
  // Fermer le menu déroulant si l'utilisateur clique en dehors
  window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropdown-btn') && !event.target.matches('.dropdown-btn *')) {
          if (dropdownContent.classList.contains('show')) {
              dropdownContent.classList.remove('show');
          }
      }
  });
});
