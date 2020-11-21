export default class Ajax
{
    constructor() {};

    getData(url, callback) {
        let req = new XMLHttpRequest();

        req.open("GET", url, true);

        req.addEventListener("load", () => {
            callback(JSON.parse(req.responseText));
        });

        req.send(null);
    };
}