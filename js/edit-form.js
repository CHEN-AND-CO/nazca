window.onload = function ()
{
    var loadingDiv = document.getElementById('loading');
    var editForm = document.getElementById('edit-param');
    var btnSubmit = document.getElementById('btn-submit')
    
    
    editForm.addEventListener('submit', (event) => {        
        editForm.style.opacity = 0;
        editForm.addEventListener('transitionend', (ev) => {
            loadingDiv.classList.remove('hidden');
            editForm.style.display = 'none';
        });
    });
}