function generatePassword() {
    var length = Number(document.getElementById("passwordLength").value),
        includeSymbols = document.getElementById("includeSymbols").checked,
        includeNumbers = document.getElementById("includeNumbers").checked,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
        retVal = "";

    if(includeSymbols) charset += "!@#$%^&*()_+=-{}[]:";
    if(includeNumbers) charset += "0123456789";

    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

document.getElementById("generateButton").addEventListener("click", function() {
    document.getElementById("passwordDisplay").value = generatePassword();
});