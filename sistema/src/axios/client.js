var axios = require("axios");

var axiosInstance = axios.create({
  // http://server/apihorasextras/public/
  //"http://192.168.0.119/horasestra/api/public/"
  // http://192.168.0.162:8090/horasextra/api/public/ meu
  //baseURL: "http://romualdocosta.eu/api/public/",
  baseURL: "http://localhost/projetovuejs/api/public/",
  responseType: "json",
  responseEncoding: "utf8",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json;charset=UTF-8",
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET,POST,PUT,DELETE,OPTIONS"
  }
});

module.exports = axiosInstance;
