import myStaff from "./src/staff/my-staff.js";


myStaff.componet();

let vista = document.querySelector('#vista');

document.querySelectorAll('a[data-value]').forEach((item) => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
    
        vista.innerHTML = ''
      
        let newElement = `<${e.target.dataset.value}></${e.target.dataset.value}>`
      
        vista.innerHTML = newElement
      });
})
  