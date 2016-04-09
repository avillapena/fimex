this.onmessage = function (url) {
    getDataFromURL(url.data.url,url.data.params,url.data.time);
};

var HttpClient = function () {
    this.get = function (Url, params, Callback) {
        var params = (params !== undefined ? '?': '') + Object.keys(params).map(function(key){ 
            return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]); 
        }).join('&');

        HttpRequest = new XMLHttpRequest();
        HttpRequest.onreadystatechange = function () {
            if (HttpRequest.readyState == 4 && HttpRequest.status == 200) {
                Callback(HttpRequest.responseText);
            }              
        };
        HttpRequest.open('GET', Url+params, true);
        HttpRequest.send();
    };

    this.post = function (Url, params, Callback) {
        var params = Object.keys(params).map(function(key){ 
            return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]); 
        }).join('&');

        HttpRequest = new XMLHttpRequest();
        HttpRequest.onreadystatechange = function () {
            if (HttpRequest.readyState == 4 && HttpRequest.status == 200) {
                console.log(HttpRequest.responseText.length);
                Callback(HttpRequest.responseText);
            }              
        };
        HttpRequest.open('POST', Url, true);
        HttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        HttpRequest.send(params);
    };
};

function getDataFromURL(url,params,time) { 
    Client = new HttpClient();
    Client.get(url, params, function (answer) {
        postMessage(answer);
        if(time !== undefined)
            setTimeout("getDataFromURL('"+url+"',"+JSON.stringify(params)+")", time);
    });
}