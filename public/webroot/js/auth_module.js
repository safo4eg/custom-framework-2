;(function() {
    let auth = {};

    auth.login = async function(payload) {
        let login = payload.get('login');
        let password = payload.get('password');
        let result = await fetch(settings.prefix + `/login?login=${login}&password=${password}`)
        return result;
    }

    window.auth_module = auth;
})();