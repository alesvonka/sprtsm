//Inicializace Naja pro ajaxove pozadavky
naja.initialize();

// Zobraz a skryj ajaxem modal pokud to Materializecss umi, kdyz tak smazu.
naja.addEventListener('success', event => {
    if (typeof event.detail.payload.hideModal !== 'undefined') {
        $('#modal').modal('hide')
    }
    if (typeof event.detail.payload.showModal !== 'undefined') {
        $('#modal').modal('show')
    }
});



// Materializecss javasript
M.AutoInit();
