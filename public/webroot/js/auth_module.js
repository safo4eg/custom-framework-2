;(function() {
    let auth = {};

    auth.get_employees_list = async function() {
        let result = await fetch(settings.prefix + '/list?table=employees');
        return result;
    }

    auth.login = async function(payload) {
        let login = payload.get('login');
        let password = payload.get('password');
        let result = await fetch(settings.prefix + `/login`, {
            method: "POST",
            body: payload
        });
        return result;
    }

    window.auth_module = auth;
})();