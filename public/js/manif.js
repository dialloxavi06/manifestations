document.addEventListener('DOMContentLoaded', function () {

    var regionField = document.querySelector('#manifestation_region');
    var communeSelect = document.querySelector('#manifestation_commune');
    var paysTiersSelect = document.querySelector('#manifestation_countries');
    var JustificationPaysTiersField = document.querySelector('#justification_pays_tiers');
    console.log(JustificationPaysTiersField)

    JustificationPaysTiersField.style.display = 'none';


    paysTiersSelect.addEventListener('change', function () {
        JustificationPaysTiersField.style.display = 'block';
    });

    regionField.addEventListener('change', function () {
        var selectedRegions = Array.from(this.selectedOptions).map(option => option.value);
        console.log(selectedRegions);
        fetchDepartements(selectedRegions);
    });


    var dateDebutInput = document.querySelector('#manifestation_date_debut');
    var dateFinInput = document.querySelector('#manifestation_date_fin');
    var dureeInput = document.querySelector('#manifestation_duree');
    var justificationDureeInput = document.querySelector('#manifestation_justification_duree');

    dateFinInput.addEventListener('change', function () {
        var dateDebut = new Date(dateDebutInput.value);
        var dateFin = new Date(dateFinInput.value);
        var difference = dateFin - dateDebut;
        var jours = difference / (1000 * 60 * 60 * 24);
        dureeInput.value = jours;
        if (jours > 20) {
            justificationDureeInput.style.display = 'block';
        } else {
            justificationDureeInput.style.display = 'none';
        }
    });
});
