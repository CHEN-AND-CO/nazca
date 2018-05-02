/************************************/
/*          consult.js              */
/* Gère l'affichage fenêtré des     */
/* différents graphes.              */
/* G. Leroy-Ferrec             2018 */
/************************************/

window.onload = function ()
{    
    var graphWindow = document.getElementById('graph-window');
    var openGraph = document.getElementById('graph-open-btn');
    var closeBtn = document.querySelector('#graph-window #close-btn');

    console.log(graphWindow);
    console.log(closeBtn);
    
    openGraph.addEventListener( 'click', (ev) => {
        if ( graphWindow )
        {            
            ev.preventDefault();
            graphWindow.classList.remove('hidden');

            closeBtn.addEventListener('click', (ev) => {
                graphWindow.classList.add('hidden');
            });
        }
    });
}