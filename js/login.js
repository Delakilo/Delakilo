function validatePasswords() {
   if (password1.value !== password2.value) {
      window.alert('Passwords do not match')
      return false
   }

   return true
}

function submitForm1Data() {
   password = document.getElementById('pwd')
   password.value = hex_sha512(password.value)
}

function submitForm2Data() {
   password1 = document.getElementById('pwd1')
   password2 = document.getElementById('pwd2')

   password1.value = hex_sha512(password1.value)
   password2.value = password1.value
}
