;(function() {
    let auth = {};

    auth.edit = async function(payload) {
        let result = await fetch(settings.auth.prefix + '/edit', {
            method: 'POST',
            headers: {
                "Content-type": "application/json"
            },
            body: payload
        });
        return result;
    }

    auth.add_patient = async function(payload) {
        let result = await fetch(settings.auth.prefix + '/add/patient', {
            method: 'POST',
            body: payload
        });
        return result;
    }

    auth.add_employee = async function(payload) {
        let result = await fetch(settings.auth.prefix + '/add/employee', {
            method: 'POST',
            body: payload
        });
        return result;
    }

    auth.search_person = async function(search_params) {
        let result = await fetch(settings.auth.prefix + `/search?${search_params}`);
        return result;
    }

    auth.get_patients_list = async function() {
        let result = await fetch(settings.auth.prefix + '/list?table=patients');
        return result;
    }

    auth.get_employees_list = async function() {
        let result = await fetch(settings.auth.prefix + '/list?table=employees');
        return result;
    }

    auth.login = async function(payload) {
        let login = payload.get('login');
        let password = payload.get('password');
        let result = await fetch(settings.auth.prefix + `/login`, {
            method: "POST",
            body: payload
        });
        return result;
    }

    window.auth_module = auth;
})();