// IE Workaround
if (!window.console) console = {log: function() {}}; 

function setCookie(name, val) {
    var cookieExpiry = 'Wed, 1 Jan 2025 00:00:00 GMT';
    var c = name + "=" + val;
    document.cookie = c + ';secure;expires=' + cookieExpiry;
};

function setDomainCookie(name, val) {
    var cookieExpiry = 'Wed, 1 Jan 2025 00:00:00 GMT';
    var c = name + "=" + val;
    document.cookie = c + ';secure;expires=' + cookieExpiry + ";domain=nhs.net;path=/";
};

function readCookie(name){
    var cookies, c, C, i;
    c = document.cookie.split('; ');
    cookies = {};

    for(i=c.length-1; i>=0; i--){
        C = c[i].split('=');
        cookies[C[0]] = C[1];
    }
    return cookies[name];
}

function deleteCookie(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};

function tickboxUpdate(e) {
    var net = readCookie("net");

    if (e.checked == true) {
        setDomainCookie("endpoint", "private");
    } else {
        setDomainCookie("endpoint", "public");
    }
};

function initialiseSettings() {
    var NHSmail2 = readCookie("NHSMail2");
    var endpoint = readCookie("endpoint");
    var net = readCookie("net");
    var cb = document.getElementsByName("publicComputer")[0];

    // Remove cookie if it's been cached
    if (NHSmail2 != undefined) {
        console.log("Removing NHSmail 2 migration cookie")
        deleteCookie("NHSMail2")
    } else {
        console.log("No migration cookie found")
    }
    
    if (net == "1") {
        setDomainCookie("endpoint", "n3");
        cb.checked = 1;
    } else {
        if (endpoint != undefined) {
            if (endpoint == "private") {
                cb.checked = 1;
            } else {
                cb.checked = 0;
            }
        } else {
            setDomainCookie("endpoint", "public");
            cb.checked = 0;
        }
    }
};

if (window.addEventListener) {
    window.addEventListener('load', initialiseSettings, false);
}
else if (window.attachEvent) {
    window.attachEvent('onload', initialiseSettings);
}
