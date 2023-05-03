;(function() {
    let interactivity_module = {};

    interactivity_module.clear_form = function(form) {
        let inputs = Array.from(form.querySelector('.inputs').children);
        inputs.forEach(elem => {
           if(elem.tagName === 'INPUT') {
               elem.value = '';
           }

           if(elem.tagName === 'SELECT') {
               let options = Array.from(elem.children);
               options.forEach(option => {
                  if(option.value === '1') option.selected;
               });
           }
        });
    }

    interactivity_module.add_new_trs = function(table, payload, modal_id) {
        let trs_list;
        if(modal_id === 'add_employee_modal') trs_list = create_table_trs_list(payload, settings.employees_thead_fields);
        if(modal_id === 'add_patient_modal') trs_list = create_table_trs_list(payload, settings.patients_thead_fields);
        add_table_body(table, trs_list);
    }

    interactivity_module.table_is_empty = function(table) {
        let table_body = table.querySelector('tbody');
        clear_table_body(table_body);

        let tr = document.createElement('TR');
        let td = document.createElement('TD');
        td.classList.add('empty');
        td.textContent = 'Пусто';
        td.colSpan = 10;

        table_body.append(tr, td);

    }

    interactivity_module.show_patients_list = function(table, payload) {
        clear_table(table);
        create_table_head(table, settings.patients_thead_fields);
        create_table_body(table, create_table_trs_list(payload, settings.patients_thead_fields));
    }

    interactivity_module.show_employees_list = function(table, payload, table_title) {
        clear_table(table);
        create_table_head(table, settings.employees_thead_fields);
        create_table_body(table, create_table_trs_list(payload, settings.employees_thead_fields, table_title));
    }

    interactivity_module.clickCancel = function(td) {
        let edit_cell = createActionsCell(table_title = 'employees');
        td.textContent = '';
        td.append(...Array.from(edit_cell.children));
    }

    interactivity_module.clickEdit = function(td) {
        td.textContent = '';
        let actions = createActions();
        actions.forEach(elem => {
            td.append(elem);
        });

        let tds = Array.from(td.parentElement.children);
        let td_info = new Map();
        let form_inputs = [];
        tds.forEach(elem => {
           if(!elem.classList.contains('action_cell')) {
               let info = fromTextContentToInput(elem);
               let general_attr = info['general_attr'];
               td_info.set(elem, general_attr);
               form_inputs.push(info['form_elem']);
           }
        });

        return [actions, td_info, form_inputs];
    }

    function create_table_trs_list(payload, fields) {
        let trs_list = [];
        payload.forEach(elem => {
            let tr = document.createElement('TR');
            let key_elem = {};
            let entries = Object.entries(elem);
            for(let i = 0; i < entries.length; i++) {
                let key = entries[i][0];
                let value = entries[i][1];

                // if(key === 'id') {
                //     let hidden_input = document.createElement('INPUT');
                //     hidden_input.type = 'hidden';
                //     hidden_input.value = value;
                //     hidden_input.name = key;
                //     tr.append(hidden_input);
                // }

                key_elem[key] = create_table_td(key, value != null? value: 'Отсутствует');
                if(key === 'id') {
                    tr.append(key_elem[key]);
                }
            }
            edit_cell = createActionsCell();

            for(let key in fields) {
                if(key !== 'action') {
                    tr.append(key_elem[key]);
                }
            }

            tr.append(edit_cell);
            trs_list.push(tr);
        });
        return trs_list;
    }

    function add_table_body(table, tr_list) {
        let tbody = table.querySelector('tbody');
        tr_list.forEach(elem => {
           tbody.append(elem);
        });
    }

    function create_table_body(table, trs_list) {
        let tbody = document.createElement('TBODY');
        trs_list.forEach(elem => {
            tbody.append(elem);
        })
        table.append(tbody);
    }

    function create_table_td(key, value) {
        let td = document.createElement('TD');
        let hidden_input = document.createElement('INPUT');
        hidden_input.type = 'hidden';
        hidden_input.value = key;

        if(key === 'id') {
            hidden_input.value = value;
            hidden_input.name = key;
            td.classList.add('hidden')
        };

        td.textContent = value;
        td.append(hidden_input);
        return td;
    }

    function create_table_head(table, fields) {
        let thead = document.createElement('THEAD');
        let tr = document.createElement('TR');
        for(let key in fields) {
            let th = document.createElement('TH');
            th.textContent = fields[key];
            tr.append(th);
        }
        thead.append(tr);
        table.append(thead);
    }

    function clear_table_body(table_body) {
        table_body.replaceChildren();
    }

    function clear_table(table) {
        table.replaceChildren();
    }

    function fromTextContentToInput(elem) {
        let general_attr = {};
        let text = elem.textContent.trim();

        let hidden_input = elem.querySelector('input[type="hidden"]');
        let hidden_input_value = hidden_input.value;
        general_attr['hidden_input'] = hidden_input;
        general_attr['text_content'] = elem.textContent;

        let form_elem;
        if(hidden_input_value === 'role' || hidden_input_value === 'department') {
            form_elem = document.getElementById(`select_${hidden_input_value}`)
            form_elem = form_elem.cloneNode(true);
            let options = Array.from(form_elem.children);
            options.forEach(option => {
               if(option.textContent === elem.textContent.trim()) option.selected;
            });
        } else {
            form_elem = document.createElement('INPUT');
            if(hidden_input.name === 'id') {
                form_elem.name = hidden_input.name;
                form_elem.value = hidden_input_value;
            } else {
                form_elem.name = hidden_input_value;
                form_elem.value = text !== 'Отсутствует'? text: '';
            }
            form_elem.classList.add('edit_input');
            if(hidden_input_value === 'date_of_birth') {
                form_elem.type = 'date';
                form_elem.value = elem.textContent.trim().match(/^\d{4}-\d{2}-\d{2}/)[0];

            } else form_elem.placeholder = hidden_input_value;
        }

        elem.textContent = '';
        elem.append(form_elem);

        return {'general_attr': general_attr, 'form_elem': form_elem};
    }

    function createActionsCell(table_title = 'patietns') {
        let td = document.createElement('TD');
        td.classList.add('action_cell');

        let edit_link = document.createElement('A');
        edit_link.href = '/';
        edit_link.classList.add('edit');
        edit_link.textContent = 'Редактировать';

        td.append(edit_link);

        if(table_title === 'patietns') {
            let application_link = document.createElement('A');
            application_link.href = '/';
            application_link.classList.add('application');
            application_link.textContent = 'Записи';
            td.append(application_link);
        }

        return td;
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