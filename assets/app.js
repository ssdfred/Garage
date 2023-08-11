//import { sub } from 'date-fns';
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
        if (description.classList.contains("visually-hidden")) {
            buttonDescription.innerText = "Voir la description";
        } else {
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
            console.log(response);
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
                    <span class="voiture-item-annee">${result.anneeMiseCirculation}</span>
                    <span class="voiture-item-price">${result.prix}€</span>
                    <p class="voiture-description">${result.description}</p>
                    <a href="/contact" class="btn-primary contact">Contact</a>
                    <a href="/" class="btn-primary retour">Retour</a>
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
// fonction pour recuperer les données du formulaire de contact

//window.onload = () => {
//    // Récupére l'élément du formulaire de contact
//    const formulaireContact = document.querySelectorAll("contact-form");
//
//    // Écoute le clic sur le bouton "Contact" de chaque voiture
//    const contactButtons = document.querySelectorAll("#contact-des");
//    contactButtons.forEach(button => {
//        button.addEventListener("click", () => {
//            // Récupére le titre de la voiture
//            const titre = button.parentElement.querySelector(".voiture-item-heading .voiture-item-name").textContent;
//            console.log(titre);
//            // Pré-remplir le champ "sujet" du formulaire de contact avec le titre de la voiture
//            const sujetInput = formulaireContact.querySelectorAll("#contact_sujet");
//            sujetInput.value = titre;
//            console.log(sujetInput.value);
//            // Affiche le titre et le formulaire pour vérification
//            alert("Titre : " + titre);
//            alert("Sujet : " + sujetInput.value);
//        });
//    });
//
//}
document.addEventListener('DOMContentLoaded', () => {
    // Récupère l'élément du formulaire de contact
    const formulaireContact = document.querySelector("#contact-form");

    // Écoute le clic sur le bouton "Contact" de chaque voiture
    const contactButtons = document.querySelectorAll(".contact");
    console.log(contactButtons);
    contactButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Récupère le titre de la voiture
            const titre = button.parentElement.querySelector(".voiture-item-heading .voiture-item-name").textContent;

            // Pré-remplit le champ "sujet" du formulaire de contact avec le titre de la voiture
            const sujetInput = formulaireContact.querySelector("#contact_sujet"); // Utilise "#contact_sujet"
            sujetInput.value = titre;

            // Affiche le titre et le formulaire pour vérification
            alert("Titre : " + titre);
            alert("Sujet : " + sujetInput.value);
        });
    });
});
