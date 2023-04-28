;(function() {
    let interactivity_module = {};

    interactivity_module.clickCancel = function(td) {
        td.textContent = '';

        let edit_btn = document.createElement('A');
        edit_btn.href = '/';
        edit_btn.classList.add('edit');
        edit_btn.textContent = 'Редактировать';

        td.append(edit_btn);
    }

    interactivity_module.clickEdit = function(td) {
        td.textContent = '';
        let actions = createActions();
        actions.forEach(elem => {
            td.append(elem);
        });

        let tds = Array.from(td.parentElement.children);
        let td_info = new Map();
        tds.forEach(elem => {
           if(!elem.classList.contains('action_cell')) {
               let general_attr = fromTextContentToInput(elem);
               td_info.set(elem, general_attr);
           }
        });

        return [actions, td_info];
    }

    function fromTextContentToInput(elem) {
        let general_attr = {};

        let hidden_input = elem.querySelector('input[type="hidden"]');
        let hidden_input_value = hidden_input.value;
        general_attr['hidden_input'] = hidden_input;
        general_attr['text_content'] = elem.textContent;
        elem.textContent = '';

        let text_input = document.createElement('INPUT');
        text_input.name = hidden_input_value;
        text_input.classList.add('edit_input');
        if(hidden_input_value === 'date_of_birth') text_input.type = 'date';
        else text_input.placeholder = hidden_input_value;

        elem.append(text_input);

        return general_attr;
    }

    function createActions() {
        let btn_save = document.createElement('A');
        btn_save.href = '/';
        btn_save.classList.add('save');
        btn_save.textContent = 'Сохранить';

        let btn_cancel = document.createElement('A');
        btn_cancel.href = '/';
        btn_cancel.classList.add('cancel');
        btn_cancel.textContent = 'Отменить';

        return [btn_save, btn_cancel];
    }

    window.interactivity_module = interactivity_module;
})();