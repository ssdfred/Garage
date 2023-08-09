//import { sub } from 'date-fns';
import './styles/app.scss';
import 'bootstrap';
const $ = require('jquery');
global.$ = $;
require('bootstrap');

const buttonDescription = document.getElementById("buttonDescription");

const description = document.getElementById("description");
buttonDescription.onclick = (e) => {
    description.classList.toggle("visually-hidden");
    if (buttonDescription.innerText === "Voir la description") {
        buttonDescription.innerText = "Cacher la description";
    } else {
        buttonDescription.innerText = "Voir la description";
    }
}

// fonxtion pour le bouton de recherche
const searchForm = document.getElementById('filter-form');
const searchResults = document.getElementById('results');

searchForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(searchForm);
    const data = {
        prix_min: formData.get('prix_min'),
        prix_max: formData.get('prix_max'),
    };
    console.log(searchForm);
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

        for (const result of response) {
            const imageUrl = result.image ? `/uploads/Voiture/${result.image}`: '';

            const voitureDiv = document.createElement('div'); // Création d'un élément div
            voitureDiv.classList.add('voiture'); // Ajout de la classe "voiture" à l'élément div
            searchResults.innerHTML = ''; // Suppression du contenu HTML body
            voitureDiv.innerHTML= `
                    
                    <h3>${result.titre}</h3>
                    <p>Année: ${result.anneeMiseCirculation}</p>
                    ${result.image ? `<img src="${imageUrl}" alt="${result.titre}" />` : ''}
                    <p>Description: ${result.description}</p>
                    <p>Prix: ${result.prix}€</p> 
                    <a class="btn btn-primary" href="/" >Retour</a>               
            `;
            searchResults.appendChild(voitureDiv); // Ajout du div dans la div parente
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête :', error.message);
        searchResults.innerHTML = '<p>Une erreur s\'est produite lors de la recherche,veuillez renseigner le pix minimun et le prix maximun.</p>';
    });
});
window.onload = () => {
    // Récupérer l'élément du formulaire de contact
    const formulaireContact = document.getElementById("contact-form");

    // Écouter le clic sur le bouton "Contact" de chaque voiture
    const contactButtons = document.querySelectorAll(".contact-des");
    contactButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Récupérer le titre de la voiture
            const titre = button.parentElement.querySelector(".voiture-item-heading .voiture-item-name").textContent;
console.log(titre);
            // Pré-remplir le champ "sujet" du formulaire de contact avec le titre de la voiture
            const sujetInput = formulaireContact.querySelector("#contact_sujet");
            sujetInput.value = titre;
console.log(sujetInput.value);
            // Afficher le titre et le formulaire pour vérification
            alert("Titre : " + titre);
            alert("Sujet : " + sujetInput.value);
        });
    });

/*    $(document).ready(function() {
        $('#form-recherche').submit(function(event) {
            event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

            // Récupérer les paramètres de recherche
            var prixMin = $('#prix_min').val();
            var prixMax = $('#prix_max').val();

            // Envoyer la requête AJAX
            $.ajax({
                url: 'search_ajax',
                type: 'POST',
                data: {
                    prix_min: prixMin,
                    prix_max: prixMax
                },
                success: function(data) {
                    // Afficher les résultats de recherche
                    $('#resultats-recherche').html(data);
                }
            });
        });
    });
*/
}
 





