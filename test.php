<html>
<head>
<script type="text/javascript">
 
function generatePassword() {
    var length = 8,
        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    //return retVal;
   
  document.getElementById("NUM_DECHARGE").value = retVal;
}
 
</script>
</head>
<body>
 
<span class="form">N° de décharge : </span>
<input maxlength="20" size="20" id="NUM_DECHARGE" style="width: 55px" value="test">
<input type="button" value="Ajouter" onclick="generatePassword()" />
 
     
</body>
</html>