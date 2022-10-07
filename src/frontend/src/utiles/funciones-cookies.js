
function setCookie(name, value, daysToLive=null) {
    let cookie = `${name}=${encodeURIComponent(value)}`;
    if (daysToLive !== null) {
    cookie += `; max-age=${daysToLive*60*60*24}`;
    }
    document.cookie = cookie;
   }

function getCookie() {
    const cookies = new Map();
    const list = document.cookie.split('; ');
    for(let cookie of list) {
        if(!cookie.includes('=')) continue;
        const [name,value] = cookie.split('=');
        cookies.set(name,value);
    }

    return cookies;
}

globalThis.setCookie = setCookie;
globalThis.getCookie = getCookie;