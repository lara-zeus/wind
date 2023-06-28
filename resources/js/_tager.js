const colors = require('tailwindcss/colors')
delete colors["black"];
delete colors["white"];

var randomProperty = function (obj) {
    var keys = Object.keys(obj);
    return obj[keys[keys.length * Math.random() << 0]];
};
const targets = document.querySelectorAll('.tager');

targets.forEach(target => {
    target.style.backgroundColor = randomProperty(colors)[200];
});
