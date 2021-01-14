let role_field = document.getElementById('type');
let school_code_field = document.getElementById('school_code_field');
school_code_field.style['display'] = "none"

if (role_field) {
  let role = role_field ? role_field.value : null;
  role_field.addEventListener("change", listenerAction)
}

function listenerAction(event) {
  let school_code_field = document.getElementById('school_code_field');
  let role = role_field ? role_field.value : null;
  if (role == 'admin') {
    school_code_field.style['display'] = "none"
  } else {
    school_code_field.style['display'] = "flex"
  }
}