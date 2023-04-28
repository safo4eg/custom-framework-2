;(function() {
    let modal_window_module = {};

    modal_window_module.save = function () {

    }

    modal_window_module.cancel = function (modal) {
        modal.classList.add('hidden');
    }

    modal_window_module.show = function (modal) {
        modal.classList.remove('hidden');

        let actions = [];
        let accept = modal.querySelector('.accept');
        let cancel = modal.querySelector('.cancel');

        actions.push(accept, cancel);

        return actions;
    }

    modal_window_module.getModalId = function (btn) {
        let id = btn.id;
        let res = id.match(/^([a-zA-Z]+_[a-zA-Z]+_).+$/);
        let modal_id = res[1] + 'modal';
        return modal_id;
    }

    window.modal_window_module = modal_window_module;
})();