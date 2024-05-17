
// Sélectionne l'élément <select> pour les pays
var PaysSelect = document.querySelector('#manifestation_countries');
var VilleSelect = document.querySelector('#manifestation_ville');
var FormVille = document.querySelector('#form-ville');
var FormVilles = document.querySelector('#form-villes');
var btnAdd = document.querySelector('#btn-add');
var autreVille = document.querySelector('#autre-ville');
var justificationPaysTiers = document.querySelector('#justification_pays_tiers');


// Afficher le champs de Rajout d'une autre ville
btnAdd.addEventListener('click', function () {
    autreVille.style.display = 'block';
});
PaysSelect.addEventListener('change', function () {
    var selectCountries = Array.from(this.selectedOptions).map(option => option.value);
    var selectedCountryId = this.value;
    VilleSelect.innerHTML = '';

    // Afficher le champ ville
    if (selectedCountryId == 63 || selectedCountryId == 55) {
        FormVille.style.display = 'block';
    } else {
        FormVille.style.display = 'none';
    }

    // si le pays est un pays tiers, afficher le champ justification
    if (selectedCountryId == 63 || selectedCountryId == 55) {
        justificationPaysTiers.style.display = 'none';
    } else {
        justificationPaysTiers.style.display = 'block';
    }

    // Ajouter une condition pour charger les villes de l'Allemagne et de la France
    if (selectCountries.includes('63') && selectCountries.includes('55')) {
        fetch('http://127.0.0.1:8000/api/villes/63').then(responseGermany => {
            if (!responseGermany.ok) {
                throw new Error('Erreur de réseau');
            }
            return responseGermany.json();
        }).then(dataGermany => {
            dataGermany.forEach(ville => {
                var option = document.createElement('option');
                option.value = ville.id;
                option.textContent = ville.nom;
                VilleSelect.appendChild(option);
            });
        }).catch(error => console.error('Erreur lors de la récupération des villes d\'Allemagne:', error));

        fetch('http://127.0.0.1:8000/api/villes/55').then(responseFrance => {
            if (!responseFrance.ok) {
                throw new Error('Erreur de réseau');
            }
            return responseFrance.json();
        }).then(dataFrance => {
            dataFrance.forEach(ville => {
                var option = document.createElement('option');
                option.value = ville.id;
                option.textContent = ville.nom;
                VilleSelect.appendChild(option);
            });
        }).catch(error => console.error('Erreur lors de la récupération des villes de France:', error));
    } else { // Si les deux pays ne sont pas sélectionnés, charger les villes normalement
        selectCountries.forEach(countryId => {
            fetch('http://127.0.0.1:8000/api/villes/' + countryId).then(response => {
                if (!response.ok) {
                    throw new Error('Erreur de réseau');
                }
                return response.json();
            }).then(data => {
                data.forEach(ville => {
                    var option = document.createElement('option');
                    option.value = ville.id;
                    option.textContent = ville.nom;
                    VilleSelect.appendChild(option);
                });
            }).catch(error => console.error('Erreur lors de la récupération des villes:', error));
        });
    }
});