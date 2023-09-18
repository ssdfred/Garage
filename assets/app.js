
import './styles/app.scss';
import 'bootstrap';
const $ = require('jquery');
global.$ = $;
require('bootstrap');

// Fonction pour le bouton "Voir la description"
// selecteur pour le bouton
const buttonDescriptions = document.querySelectorAll(".buttonDescription");

// boucle pour chaque bouton
[...buttonDescriptions].forEach(buttonDescription => {
    const description = buttonDescription.previousElementSibling;
    //ecouteur d'evenement
    buttonDescription.addEventListener("click", (e) => {
        
        description.classList.toggle("visually-hidden");
        // Vérifier si la description est actuellement cachée
        if (description.classList.contains("visually-hidden")) {
            buttonDescription.innerText = "Voir la description";
        } else {
            //si la description est visible, on change le texte du bouton
            buttonDescription.innerText = "Cacher la description";
        }
    });
});


// fonction pour le bouton de recherche
const searchForm = document.getElementById('filter-form');
const searchResults = document.getElementById('results');

searchForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(searchForm);
    const data = {
        prix_min: formData.get('prix_min'),
        prix_max: formData.get('prix_max'),
    };
    //console.log(searchForm);
    fetch('/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())

        .then(response => {
            ;
            
            searchResults.innerHTML = ''; // Efface le contenu précédent avant d'ajouter les nouveaux résultats
            let rowDiv = document.createElement('div'); // Création d'un élément div pour chaque ligne
            rowDiv.classList.add('row'); // Ajout de la classe "row"
            
            let count = 0; // initialisation du compteur
            
            for (const result of response) {
                const imageUrl = result.image ? `/uploads/Voiture/${result.image}` : '';

                const voitureDiv = document.createElement('div'); // Création d'un élément div
                voitureDiv.classList.add('col-md-4', 'voiture-item'); // Ajout des classes "col-md-4" et "voiture-item"

                // Construction de la structure HTML pour chaque résultat
                voitureDiv.innerHTML = `
                
                    <img class="voiture-item-image" src="${imageUrl}" alt="${result.image}">
                    <h3 class="voiture-item-heading">
                        <span class="voiture-item-name">${result.titre}</span>
                    </h3>
                    <div><span class="voiture-item-annee">Année de mise en circulation : ${result.anneeMiseCirculation}</span></div>
                    <div><span class="voiture-item-kilometrage">Kilométrage : ${result.kilometrage}</span></div>
                    <p class="voiture-description">${result.description}</p>
                    <div>
                    <span class="voiture-item-price">Tarif : ${result.prix}€</span>
                    </div>
                    <a href="/contact" class="btn btn-primary contact">Contact</a>
                    <a href="/" class="btn btn-primary retour">Retour</a>
                   
                `;

                rowDiv.appendChild(voitureDiv); // Ajout du div dans la ligne
                count++; // Augmentation du compteur

                // Lorsque le compteur atteint 3 éléments, ajouter la ligne à la div "results" et réinitialiser le compteur
                if (count === 3) {
                    searchResults.appendChild(rowDiv);
                    rowDiv = document.createElement('div'); // Créer une nouvelle ligne
                    rowDiv.classList.add('row'); // Ajout de la classe "row" à la nouvelle ligne
                    count = 0; // Réinitialiser le compteur
                }
            }
            
            // Si la dernière ligne n'est pas pleine (moins de 3 éléments), ajouter la ligne restante
            if (count > 0) {
                searchResults.appendChild(rowDiv);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête :', error.message);
            searchResults.innerHTML = '<p>Une erreur s\'est produite lors de la recherche,veuillez renseigner le prix minimum et le prix maximum.</p>';
        });
});


