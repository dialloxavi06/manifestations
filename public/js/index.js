document.addEventListener('DOMContentLoaded', function () {
    var navListItems = document.querySelectorAll('div.setup-panel div a');
    var allWells = document.querySelectorAll('.setup-content');
    var allNextBtn = document.querySelectorAll('.nextBtn');
    var allPrevBtn = document.querySelectorAll('.prevBtn');

    allWells.forEach(function (item) {
        item.style.display = 'none';
    });
    
    document.getElementById('step-1').style.display = 'block'; // Montrer seulement la première étape au départ

    navListItems.forEach(function (navItem) {
        navItem.addEventListener('click', function (e) {
            e.preventDefault();
            var targetId = navItem.getAttribute('href').substring(1);
            var target = document.getElementById(targetId);
            var curItem = navItem;

            if (!curItem.classList.contains('disabled')) {
                navListItems.forEach(function (item) {
                    item.classList.remove('btn-primary');
                    item.classList.add('btn-default');
                });
                curItem.classList.remove('btn-default');
                curItem.classList.add('btn-primary');
                allWells.forEach(function (well) {
                    well.style.display = 'none';
                });
                target.style.display = 'block';
                target.querySelector('input').focus();
            }
        });
    });

    allPrevBtn.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var curStep = btn.closest('.setup-content');
            var curStepBtn = curStep.id;
            var prevStepWizard = document.querySelector('div.setup-panel div a[href="#' + curStepBtn + '"]').parentElement.previousElementSibling.querySelector('a');

            prevStepWizard.removeAttribute('disabled');
            prevStepWizard.click();
        });
    });

    allNextBtn.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var curStep = btn.closest('.setup-content');
            var curStepBtn = curStep.id;
            var nextStepWizard = document.querySelector('div.setup-panel div a[href="#' + curStepBtn + '"]').parentElement.nextElementSibling.querySelector('a');
            var curInputs = curStep.querySelectorAll('input[type="text"], input[type="url"]');
            var isValid = true;

            curInputs.forEach(function (input) {
                if (!input.validity.valid) {
                    isValid = false;
                    input.closest('.form-group').classList.add('has-error');
                }
            });

            if (isValid) {
                nextStepWizard.removeAttribute('disabled');
                nextStepWizard.click();
            }
        });
    });

    // Ajout d'un gestionnaire de clic pour le bouton "Nouvelle Manifestation"
    var nouvelleManifestationBtn = document.getElementById('nouvelle-manifestation');
    nouvelleManifestationBtn.addEventListener('click', function (e) {
        console.log('Nouvelle manifestation');

        // Masquer toutes les étapes sauf la première
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-3').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';

        // Réinitialiser les boutons de navigation
        navListItems.forEach(function (item, index) {
            item.classList.remove('btn-primary');
            if (index === 0) {
                item.classList.add('btn-primary');
            } else {
                item.classList.add('btn-default');
            }
        });

        // Ajouter un attribut pour suivre l'état de la manifestation ouverte
        nouvelleManifestationBtn.setAttribute('data-opened', 'true');
    });

    // Si une autre manifestation est ouverte, fermer les étapes supplémentaires lors du chargement de la page
    if (nouvelleManifestationBtn.getAttribute('data-opened') !== 'true') {
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-3').style.display = 'none';
    }
});
