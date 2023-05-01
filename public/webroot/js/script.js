

if(settings.auth.prefix + '/list' === settings.auth.current_uri) {
    let table = document.querySelector('table');
    let table_title = document.getElementById('table_title');
    let employees_tab = document.getElementById('employees_tab');
    let patients_tab = document.getElementById('patients_tab');

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
                   console.log(payload);
               }
           });
        });
    }

    employees_tab.onclick = (event) => {
        patients_tab.classList.remove('active');
        employees_tab.classList.add('active');
        table_title.textContent = 'Работники';

        auth_module.get_employees_list().then(response => {
            response.text().then(text => {
                let payload = JSON.parse(text).data;
                interactivity_module.show_employees_list(table, payload);
            });
        });
    }

    patients_tab.onclick = (event) => {
        employees_tab.classList.remove('active');
        patients_tab.classList.add('active');
        table_title.textContent = 'Пациенты';

        auth_module.get_patients_list().then(response => {
           response.text().then(text => {
               let payload = JSON.parse(text).data;
               interactivity_module.show_patients_list(table, payload);
           });
        });
    }

    // let add_employee_btn = document.getElementById('add_employee_btn');
    // table.addEventListener('click', edit);
    //
    // add_employee_btn.addEventListener('click', function() {
    //    let modal_id = modal_window_module.getModalId(add_employee_btn);
    //    let modal = document.getElementById(modal_id);
    //    let actions = modal_window_module.show(modal);
    //
    //    actions[0].addEventListener('click', modal_accept(actions[0], modal));
    //    actions[1].addEventListener('click', modal_cancel(actions[1], modal));
    //
    // });
}


if(settings.auth.prefix + '/login' === settings.auth.current_uri) {
    let login_form = document.getElementById('login_form');
    let login_btn = document.getElementById('login_btn');

    login_btn.onclick = (event) => {
        event.preventDefault();
        let payload = new FormData(login_form);
        auth_module.login(payload).then(response => {
            response.text().then(text => {
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

function modal_accept(self, modal) {

    let func = () => {
        let form = modal.querySelector('.general-form');
        let payload = new FormData(form);
        // здесь отправка запроса на сервер(в нем все остальные пункты)

        fetch('employee.json').then(response => {
            response.text().then(data => { // в теле будет имитация принятия данных и вывода их в таблицу
                modal_window_module.cancel(modal);
                self.removeEventListener('click', func);
                console.log(JSON.parse(data));
            });
        });
    }
    return func;
    // получить все данные из формы +
    // отправить данные на сервер
    // обработать данные(валидация)
    // добавить пользователя в таблицу ++
    // закрыть модальное окно
}

function modal_cancel(self, modal) {
    let func = () => {
      modal_window_module.cancel(modal);
      self.removeEventListener('click', func);
    };
    return func;
}

function edit(event) {
    event.preventDefault();
    if(event.target.classList.contains('edit')) {
        let td = event.target.parentElement;
        let [actions, td_info] = interactivity_module.clickEdit(td);

        actions[0].addEventListener('click', (event) => {
            console.log(
                'Отправка запроса на сервер:\r\n' +
                'Получение новых данных в формате JSON\r\n' +
                'Занесение всех этих данных в соответствующую ячейку\r\n'
            );
        });

        actions[1].addEventListener('click', (event) => {
            for(let [elem, info] of td_info) {
                elem.textContent = info['text_content'];
                elem.append(info['hidden_input']);
            }
            interactivity_module.clickCancel(td);
        });
    }
}