

if(settings.auth.prefix + '/list' === settings.auth.current_uri) {
    let table = document.querySelector('table');
    let table_title = document.getElementById('table_title');
    let employees_tab = document.getElementById('employees_tab');
    let patients_tab = document.getElementById('patients_tab');

    let add_employee_btn = document.getElementById('add_employee_btn');
    let add_patient_btn = document.getElementById('add_patient_btn');

    let search_btn = document.getElementById('search_btn');

    search_btn.onclick = (event) => {
        event.preventDefault();
        let search_form = document.getElementById('search_form');
        let form_data_array = Array.from(new FormData(search_form));
        let search_params = '';
        for(let [key, value] of form_data_array) {
            if(value !== '') {
                search_params += (search_params !== '')?
                    ("&" + key + '=' + value.toLowerCase()):
                    (key + '=' + value.toLowerCase());
            }
        }

        auth_module.search_person(search_params).then(response => {
           response.text().then(text => {
               let payload = JSON.parse(text).data;
               if(response.status < 400) {
                   if(payload.length !== 0) {
                       let table_title_text = table_title.textContent.toLowerCase();
                       if(table_title_text === 'работники') {
                           interactivity_module.show_employees_list(table, payload, table_title_text);
                           if(employees_tab.classList.contains('active')) employees_tab.classList.remove('active');
                           else if(patients_tab.classList.contains('active')) patients_tab.classList.remove('active');
                       } else {
                           interactivity_module.show_patients_list(table, payload);
                       }
                   }
                   else interactivity_module.table_is_empty(table);
               }
           });
        });
    }

    if(employees_tab != null) {
        employees_tab.onclick = (event) => {
            if(patients_tab && patients_tab.classList.contains('active')) patients_tab.classList.remove('active');
            if(employees_tab) employees_tab.classList.add('active');
            table_title.textContent = 'Работники';

            auth_module.get_employees_list().then(response => {
                response.text().then(text => {
                    let payload = JSON.parse(text).data;
                    interactivity_module.show_employees_list(table, payload, table_title.textContent.trim().toLowerCase());
                });
            });
        }
    }

    if(patients_tab != null) {
        patients_tab.onclick = (event) => {
            if(employees_tab && employees_tab.classList.contains('active')) employees_tab.classList.remove('active');
            if(patients_tab) patients_tab.classList.add('active');
            table_title.textContent = 'Пациенты';

            auth_module.get_patients_list().then(response => {
                response.text().then(text => {
                    let payload = JSON.parse(text).data;
                    interactivity_module.show_patients_list(table, payload);
                });
            });
        }
    }


    table.addEventListener('click', edit(table_title));

    if(add_employee_btn != null) {
        add_employee_btn.addEventListener('click', function() {
            let modal_id = modal_window_module.getModalId(add_employee_btn);
            let modal = document.getElementById(modal_id);
            let actions = modal_window_module.show(modal);

            actions[0].addEventListener('click', modal_accept(actions[0], modal, table, table_title));
            actions[1].addEventListener('click', modal_cancel(actions[1], modal));

        });
    }

    if(add_patient_btn != null) {
        add_patient_btn.addEventListener('click', function() {
            let modal_id = modal_window_module.getModalId(add_patient_btn);
            let modal = document.getElementById(modal_id);
            let actions = modal_window_module.show(modal);

            actions[0].addEventListener('click', modal_accept(actions[0], modal, table, table_title));
            actions[1].addEventListener('click', modal_cancel(actions[1], modal));

        });
    }
}

if(
    settings.auth.current_uri.search(/^.+\/applications\/patient\?.+/) !== -1 ||
    settings.auth.current_uri.search(/^.+\/applications\/doctor\?.+/) !== -1
) {
    let add_application_btn = document.getElementById('add_application_btn');
    let cancel_modal = document.getElementById('cancel_modal');
    let modal_id = modal_window_module.getModalId(add_application_btn);
    let modal = document.getElementById(`${modal_id}`);
    add_application_btn.onclick = (event) => {
        event.preventDefault();
        modal_window_module.show(modal);
    };

    cancel_modal.onclick = (event) => {
        modal_window_module.cancel(modal);
    }
}

if(settings.auth.prefix + '/login' === settings.auth.current_uri) {
    let login_form = document.getElementById('login_form');
    let login_btn = document.getElementById('login_btn');

    login_btn.onclick = (event) => {
        event.preventDefault();
        let payload = new FormData(login_form);
        auth_module.login(payload).then(response => {
            response.text().then(text => {
                console.log(text);
                text = JSON.parse(text);
                if(response.status < 400) {
                    if(response.status === 302) {
                        window.location.href = settings.auth.prefix + text.url;
                    }
                } else {
                    console.log(text);
                }
            });
        });
    };
}

function modal_accept(self, modal, table, table_title) {

    let func = () => {
        let modal_id = modal.id;
        let form = modal.querySelector('form');
        let payload = new FormData(form);

        if(modal_id === 'add_employee_modal') {
            auth_module.add_employee(payload).then(response => {
                response.text().then(text => {
                    if(response.status < 400) {
                        if(table_title.textContent.toLowerCase() === 'работники') {
                            console.log(text);
                            payload = JSON.parse(text).data;
                            console.log(payload);
                            interactivity_module.add_new_trs(table, payload, modal_id);
                        }
                        interactivity_module.clear_form(form);
                        modal_window_module.cancel(modal);
                        self.removeEventListener('click', func);
                    } else {
                        console.log(text);
                    }
                });
            });
        }

        if(modal_id === 'add_patient_modal') {
            auth_module.add_patient(payload).then(response => {
               response.text().then(text => {
                   if(response.status < 400) {
                       if(table_title.textContent.toLowerCase() === 'пациенты') {
                           payload = JSON.parse(text).data;
                           interactivity_module.add_new_trs(table, payload, modal_id);
                       }
                   } else {
                       console.log(text);
                   }
                   interactivity_module.clear_form(form);
                   modal_window_module.cancel(modal);
                   self.removeEventListener('click', func);
               });
            });
        }

    }
    return func;
}

function modal_cancel(self, modal) {
    let func = () => {
      modal_window_module.cancel(modal);
      self.removeEventListener('click', func);
    };
    return func;
}

function edit(table_title) {

    return function(event) {
        event.preventDefault();
        if(event.target.classList.contains('edit')) {
            let td = event.target.parentElement;
            let [actions, td_info, form_inputs] = interactivity_module.clickEdit(td);

            actions[0].addEventListener('click', (event) => {
                let table = table_title.textContent.trim().toLowerCase();
                let payload = {};
                payload["table"] = table;
                form_inputs.forEach(elem => {
                   payload[elem.name] = elem.value;
                });
                payload = JSON.stringify(payload);
                auth_module.edit(payload).then(response => {
                    response.text().then(text => {
                        let payload = JSON.parse(text).data;
                        if(response.status < 400) {
                            for(let [elem, info] of td_info) {
                                let text_content =
                                    (payload[0][info['hidden_input'].value] != null)? payload[0][info['hidden_input'].value]: 'Отсутствуут';
                                elem.textContent = text_content;
                                elem.append(info['hidden_input']);
                            }
                        }
                    });
                });
                interactivity_module.clickCancel(td, table_title);
            });

            actions[1].addEventListener('click', (event) => {
                for(let [elem, info] of td_info) {
                    elem.textContent = info['text_content'];
                    elem.append(info['hidden_input']);
                }
                interactivity_module.clickCancel(td, table_title);
            });
        } else if(event.target.classList.contains('application')) {
            let link = event.target;
            let tr = event.target.parentElement.parentElement;
            let patient_id = tr.querySelector('td.hidden input[type="hidden"]').value;
            link.href = settings.auth.prefix + `/applications/patient?id=${patient_id}`;
            window.location.href = link.href;
        }
    }
}