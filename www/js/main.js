document.addEventListener('DOMContentLoaded', () => {

    naja.historyHandler.snippetCache = false;
    naja.initialize();

    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);

    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);

});

naja.addEventListener('success', event => {

    if (typeof event.detail.payload.hideModal !== 'undefined') {

        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);

        var elem = document.querySelector('.modal');
        var instance = M.Modal.getInstance(elem);
        instance.close();
    }

    if (typeof event.detail.payload.showModal !== 'undefined') {


        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);

        var elem = document.querySelector('.modal');
        var instance = M.Modal.getInstance(elem);
        instance.open();
    }
});
