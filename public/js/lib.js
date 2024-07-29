function addEventListenerMulti(array,event,callback) {
    array.forEach(element => {
        element.addEventListener(event,callback);    
    });
}