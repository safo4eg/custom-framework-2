
if('dd' === '/practic/profile_admin_employees_list.html') {
    let table = document.querySelector('table');
    let add_employee_btn = document.getElementById('add_employee_btn');

    table.addEventListener('click', edit);

    add_employee_btn.addEventListener('click', function() {
       let modal_id = modal_window_module.getModalId(add_employee_btn);
       let modal = document.getElementById(modal_id);
       let actions = modal_window_module.show(modal);

       actions[0].addEventListener('click', modal_accept(actions[0], modal));
       actions[1].addEventListener('click', modal_cancel(actions[1], modal));

    });
}


if(settings.prefix + '/login' === settings.current_uri) {
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
                        window.location.href = settings.prefix + text.url;
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