
document.addEventListener('DOMContentLoaded', function () {
    var dateDebutInput = document.querySelector('#manifestation_date_debut');
    var dateFinInput = document.querySelector('#manifestation_date_fin');
    var dureeInput = document.querySelector('#manifestation_duree');
    var justificationDureeInput = document.querySelector('#manifestation_justification_duree');



    // Ajouter un écouteur d'événement au champ date_fin
    dateFinInput.addEventListener('change', function () { // Convertir les dates en objets Date
        var dateDebut = new Date(dateDebutInput.value);
        var dateFin = new Date(dateFinInput.value);

        // Calculer la différence en millisecondes
        var difference = dateFin - dateDebut;

        // Convertir la différence en jours
        var jours = difference / (1000 * 60 * 60 * 24);

        // Mettre à jour la valeur de l'input
        dureeInput.value = jours;

        // Afficher ou masquer le champ justification_duree
        if (jours > 20) {
            justificationDureeInput.style.display = 'Block';
        } else {
            justificationDureeInput.style.display = 'none';
        }
    });
});