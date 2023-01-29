
let jktitle = document.getElementById("jokename");
jktitle.addEventListener("blur", jkTitleHandler);

let jkArea = document.getElementById("fulljoke");
jkArea.addEventListener("blur", jkHandler);

const inputField=document.getElementById("jokename");
inputField.addEventListener("input", getCount);


document.getElementById("jform").addEventListener("submit", validateSubmitJoke);