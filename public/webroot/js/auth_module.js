;(function() {
    let auth = {};

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