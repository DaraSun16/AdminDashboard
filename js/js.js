let pswrd = document.getElementById('pswrd');
let toggleBtn = document.getElementById('toggleBtn');

let lowerCase = document.getElementById('lower');
let upperCase = document.getElementById('upper');
let digit = document.getElementById('number');
let specialCar = document.getElementById('special');
let minLength = document.getElementById('length');
let button = document.getElementById('ok');

function checkPassword(data){
  const lower = new RegExp('(?=.*[a-z])');
  const upper = new RegExp('(?=.*[A-Z])');
  const number = new RegExp('(?=.*[0-9])');
  const special = new RegExp('(?=.*[!@#$%^&*()_+\\-=\\[\\]{};:\'",.<>/?])');
  const length = new RegExp('(?=.{8,})');

  // lower validation check
  if (lower.test(data)) {
    lowerCase.classList.add('valid');
  } else {
    lowerCase.classList.remove('valid');
  }

  // upper validation check
  if (upper.test(data)) {
    upperCase.classList.add('valid');
  } else {
    upperCase.classList.remove('valid');
  }
  // number validation check
  if (number.test(data)) {
    digit.classList.add('valid');
  } else {
    digit.classList.remove('valid');
  }
  // special character validation check
  if (special.test(data)) {
    specialCar.classList.add('valid');
  } else {
    specialCar.classList.remove('valid');
  }
  // length validation check
  if (length.test(data)) {
    minLength.classList.add('valid');
  } else {
    minLength.classList.remove('valid');
  }

  if(lower.test(data) && upper.test(data) && number.test(data) && special.test(data) && length.test(data)) {
    button.disabled = false;
  }
  else {
    button.disabled = true;
  }
}

toggleBtn.onclick = function() {
  if (pswrd.type === 'password'){
    pswrd.setAttribute('type', 'text');
    toggleBtn.classList.add('hide');
  } else {
    pswrd.setAttribute('type', 'password');
    toggleBtn.classList.remove('hide');
  }
}