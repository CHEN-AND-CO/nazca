window.onload = function () {
    var profiles = document.querySelectorAll('tr');
    var btnEdit = document.querySelectorAll('tr .edit-button');
    var btnDelete = document.querySelectorAll('tr .delete-button');


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
                location.href = '/action.php?action=del_param&id=' + btnDelete[i].id;
                ev.stopPropagation();
            });
        }
    }
};

