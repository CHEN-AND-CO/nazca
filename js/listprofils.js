window.onload = function () {
    var profiles = document.querySelectorAll('tr');
    var btnEdit = document.querySelectorAll('tr .edit-button');
    var btnDelete = document.querySelectorAll('tr .delete-button');

    var confirmDelete = document.getElementById('confirm-delete');

    for (const i in profiles)
    {
        if (typeof profiles[i] === 'object')
        {        
            profiles[i].addEventListener('click', (ev) => {
                location.href = '/consultation.php?id=' + profiles[i].id;
            });
        }
    }

    for (const i in btnEdit)
    {
        if (typeof btnEdit[i] === 'object')
        {        
            btnEdit[i].addEventListener('click', (ev) => {
                location.href = '/add.php?id=' + btnEdit[i].id;
                ev.stopPropagation();
            });
        }
    }

    for (const i in btnDelete)
    {
        if (typeof btnDelete[i] === 'object')
        {        
            btnDelete[i].addEventListener('click', (ev) => {
                //location.href = '/action.php?action=del_param&id=' + btnDelete[i].id;
                confirmDelete.classList.remove('hidden');

                var yesBtn = document.getElementById('delete-yes');
                var noBtn = document.getElementById('delete-no');

                yesBtn.addEventListener('click', (ev) => {
                    confirmDelete.classList.add('hidden');
                    location.href = '/action.php?action=del_param&id=' + btnDelete[i].id;
                });
                console.log(btnDelete[i].id);

                noBtn.addEventListener('click', (ev) => {
                    confirmDelete.classList.add('hidden');
                });

                ev.stopPropagation();
            });
        }
    }
};

