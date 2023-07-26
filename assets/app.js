import { sub } from 'date-fns';
import './styles/app.scss';
import 'bootstrap';


//var contactLink = document.querySelector('#contact-form');
//var sujetInput = document.getElementById('sujet-titre').innerText;
//var anneeInput = document.getElementById('sujet-annee').innerText
//;
//var info = sujetInput + anneeInput;
//alert(info);

//if (document.getElementById('sujet-titre') && document.getElementById('sujet-annee') != null) {
//;
//        alert(info);
//        contactLink.addEventListener('click', function () {
//                contactLink.insertAdjacentText('beforeend', info.innerText)
//                alert(contactLink);
//                document.getElementById('sujet').setAttribute('sujet', info);
//                alert(info);
//        });
//}
//lert(info);
//ontactLink.addEventListener('click',
//   function (event) {
//       event.preventDefault();


//       alert(contactLink);

//       contactLink.value = info;
//      // var  titre = contactLink.setAttribute('data-titre');
//      titre.document.getElementById('sujet').createAttribute('sujet', info);
//lert(info);
//       window.location.href = "contact";
//   });
//const buttonDescription = document.getElementById("buttonDescription");
//
//const description = document.getElementById("description");
//buttonDescription.onclick = (e) => {
//    description.classList.toggle("visually-hidden");
//    if (buttonDescription.innerText === "Voir la description") {
//        buttonDescription.innerText = "Cacher la description";
//    } else {
//        buttonDescription.innerText = "Voir la description";
//    }
//}
 // Fonction de recherche pour les voitures
 // Fonction de recherche pour les voitures
//function convertToDecimal(value) {
//    return parseFloat(value.replace(',', '.'));
//}

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
       console.log(data);

        for (const result of response) {
            const imageUrl = result.image ? `/uploads/Voiture/${result.image}`: '';
           
            const voitureDiv = document.createElement('div'); // Création d'un élément div
            voitureDiv.classList.add('voiture'); // Ajout de la classe "voiture" à l'élément div
           
            voitureDiv.innerHTML= `
                
                    <h3>${result.titre}</h3>
                    <p>Année: ${result.anneeMiseCirculation}</p>
                    ${result.image ? `<img src="${imageUrl}" alt="${result.titre}" />` : ''}
                    <p>Description: ${result.description}</p>
                    <p>Prix: ${result.prix}€</p>
                
            `;
            searchResults.appendChild(voitureDiv); // Ajout du div dans la div parente

        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête :', error.message);
        searchResults.innerHTML = '<p>Une erreur s\'est produite lors de la recherche.</p>';
    });
});
