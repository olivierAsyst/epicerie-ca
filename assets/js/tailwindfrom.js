document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('createProductModal'); // Le popup modal
    const modalToggleButtons = document.querySelectorAll('[data-modal-toggle="createProductModal"]'); // Boutons pour afficher/masquer le modal
    const form = modal.querySelector('form'); // Le formulaire dans le modal

    // Afficher ou masquer le modal
    modalToggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            modal.classList.toggle('hidden');
        });
    });

    // Gérer la soumission du formulaire
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Empêche le rechargement de la page

        // Récupérer les données du formulaire
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            // Envoyer les données au serveur
            const response = await fetch('/admin/category/create', { // Remplacez `/category/add` par votre route Symfony
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message); // Message de succès
                modal.classList.add('hidden'); // Fermer le modal
                form.reset(); // Réinitialiser le formulaire
                // Ajoutez ici la logique pour mettre à jour dynamiquement la liste des produits (par ex. ajouter un nouvel élément dans le DOM)
            } else {
                alert(result.error || 'Une erreur est survenue');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Impossible de traiter la demande');
        }
    });
});