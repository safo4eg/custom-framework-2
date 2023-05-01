;(function() {
    let settings = {};

    let location_href = window.location.href;
    settings.auth = {
        'prefix': '/practic/custom-framework-2',
        'current_uri': location_href.replace('http://localhost', ''),
    };

    settings.employees_thead_fields = {
        name: 'Имя',
        surname: 'Фамилия',
        patronymic: 'Отчество',
        date_of_birth: 'Дата рождения',
        role: 'Должность',
        specialization: 'Специализация',
        department: 'Отделение',
        cabinet: 'Кабинет',
        status_id: 'Статус',
        action: 'Действие'
    };

    settings.patients_thead_fields = {
        name: 'Имя',
        surname: 'Фамилия',
        patronymic: 'Отчество',
        date_of_birth: 'Дата рождения',
        status_id: 'Статус',
        action: "действие"
    };

    window.settings = settings;
})();