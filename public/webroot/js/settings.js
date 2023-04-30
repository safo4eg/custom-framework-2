;(function() {
    let location_href = window.location.href;
    let auth = {
        'prefix': '/practic/custom-framework-2',
        'current_uri': location_href.replace('http://localhost', ''),
    };

    window.settings = auth;
})();