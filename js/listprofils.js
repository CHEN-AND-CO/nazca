/************************************/
/*          listprofils.js          */
/* Gère les boutons et éléments     */
/* cliquables de la page accueil    */
/* G. Leroy-Ferrec             2018 */
/************************************/

window.onload = function () {
    //Récupération des éléments du DOM
    var profiles = document.querySelectorAll('tbody tr');
    var btnEdit = document.querySelectorAll('tr .edit-button');
    var btnDelete = document.querySelectorAll('tr .delete-button');

    var confirmDelete = document.getElementById('confirm-delete');

    //Définition des écouteurs d'événements sur toutes les lignes du tableau
    for (const i in profiles)
    {
        if (typeof profiles[i] === 'object')
        {        
            profiles[i].addEventListener('click', (ev) => {
                location.href = '/consultation.php?id=' + profiles[i].id;
            });
        }
    }

    //Écouteurs d'événements pour tous les boutons d'édition
    for (const i in btnEdit)
    {
        if (typeof btnEdit[i] === 'object')
        {        
            btnEdit[i].addEventListener('click', (ev) => {
                location.href = '/add.php?id=' + btnEdit[i].id;
                ev.stopPropagation(); //Stoppe la propagation de l'évenement
            });
        }
    }

    //Boutons de suppression
    for (const i in btnDelete)
    {
        if (typeof btnDelete[i] === 'object')
        {        
            btnDelete[i].addEventListener('click', (ev) => {
                confirmDelete.classList.remove('hidden');

                //Configuration de la fenêtre de confirmation
                var yesBtn = document.getElementById('delete-yes');
                var noBtn = document.getElementById('delete-no');

                yesBtn.addEventListener('click', (ev) => {
                    confirmDelete.classList.add('hidden');
                    location.href = '/action.php?action=del_param&id=' + btnDelete[i].id;
                });

                noBtn.addEventListener('click', (ev) => {
                    confirmDelete.classList.add('hidden');
                });

                ev.stopPropagation(); //Stoppe la propagation de l'évenement
            });
        }
    }
};

