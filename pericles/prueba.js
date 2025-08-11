function callinvoce(){

    var request = new XMLHttpRequest();
          
    request.open('GET', 'http://134.209.112.50/api/v1.0/invoices');

    request.setRequestHeader('Content-Type', 'application/json');
    request.setRequestHeader('X-Auth-App-Key', 'P9kSnp/2Jv+AVy7ktrx9+ansxp4VkESOaBqw1veGIr5LAoHWCWxg9NgeUA0/Ogq+');

    request.onreadystatechange = function () {
    if (this.readyState === 4) {
        console.log('Status:', this.status);
        console.log('Headers:', this.getAllResponseHeaders());
        console.log('Body:', this.responseText);
    }
    };

    request.send();
}