;(function() {
    let interactivity_module = {};

    interactivity_module.show_employees_list = function(table, payload) {
        let table_body = table.querySelector('tbody');
        clear_table_body(table_body);
        create_table_rows(table_body, payload);
    }

    interactivity_module.clickCancel = function(td) {
        td.textContent = '';
        let edit_cell = createEditCell();
        td.append(edit_cell);
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

    function create_table_rows(table, payload) {
        payload.forEach(elem => {
           let tr = document.createElement('TR');
           let key_elem = {};
           let entries = Object.entries(elem);
           for(let i = 0; i < entries.length; i++) {
               let key = entries[i][0];
               let value = entries[i][1];
               key_elem[key] = create_table_td(key, value != null? value: 'Отсутствует');
           }

           edit_cell = createEditCell();

           tr.append(
               key_elem['name'], key_elem['surname'], key_elem['patronymic'],
               key_elem['date_of_birth'], key_elem['role_id'],key_elem['specialization'],
               key_elem['department_id'], key_elem['cabinet'], key_elem['status_id'], edit_cell
           );
           table.append(tr);
        });
    }

    function create_table_td(key, value) {
        let td = document.createElement('TD');
        let hidden_input = document.createElement('INPUT');
        hidden_input.type = 'hidden';
        hidden_input.value = key;

        td.textContent = value;
        return td;
    }

    function clear_table_body(table_body) {
        table_body.replaceChildren();
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

    function createEditCell() {
        let edit_cell = document.createElement('TD');
        edit_cell.classList.add('action_cell');

        let edit_link = document.createElement('A');
        edit_link.href = '/';
        edit_link.classList.add('edit');
        edit_link.textContent = 'Редактировать';

        edit_cell.append(edit_link)
        return edit_cell;
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