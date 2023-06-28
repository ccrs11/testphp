import config from "../config.js";

let componet = await config.phatname(import.meta.url)


export default {
    name: componet[2],
    componet() {
        this.name = class extends HTMLElement {
            url = componet[3]+"campers/"
            constructor() {
                super();

                this.innerHTML = componet[0];
            }
            static get observedAttributes() {
                return [];
            }

            handleEvent(e) {

            }

            sendMesaggerEvent(e) {
                console.log(e.target.textContent);
            }


            attributeChangedCallback(attr, oldValue, newValue) {
                // console.log(attr);
                // console.log(oldValue);
                // console.log(newValue);

            }

            async drawtable() {


                let headersList = {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }


                let response = await fetch(this.url, {
                    method: "GET",
                    headers: headersList
                });

                let data = await response.json();
                console.log(data);
                let plantilla_city = ''
                let plantilla_areas = ''
                let plantilla_tb = ''
                data.Message.forEach((item) => {

                    plantilla_tb += `
                    
                    <tr>
                        <td>${item.nombre}</td>
                        <td>${item.apellido}</td>
                        <td>${item.fecha_de_nacimiento}</td>
                        <td>${item.region}</td>
                        <td >
                            <div class="accion">
                                <div >
                                <button  data-id="${item.idCamper}" data-name="edit">
                                    Edit
                                    <i  class='bx bxs-edit-alt'></i>
                                </button>
                                    
                                </div>
                                <div >
                                <button style="width: 40px;" >
                                    <h4 data-id="${item.idCamper}"  data-name='delete'>x</h4>
                                </button>
                                </div>
                            </div>

                        </td>
                    </tr>
                    
                    `


                });

                let response_city = await fetch("http://localhost/ApolT01-009/testphp/departamento", {
                    method: "GET",
                    headers: headersList
                });
                data = await response_city.json();
                data.Message.forEach((item) => {

                    plantilla_city += `
                        <option value="${item.idDep}">${item.departamento}</option>
                    `
                });

                this.querySelector('#idDep').innerHTML = plantilla_city;



                this.querySelector('#data-get').innerHTML = plantilla_tb;
            }

            async delete(item) {
                let headersList = {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }
                console.log(item.id);
                let response = await fetch(`${this.url}${item.id}`, {
                    method: "DELETE",
                    headers: headersList
                });

                let data = await response.json();
                data.Message == "Done" ? alert(`item eliminado con exito`) : alert(`item no puedo ser eliminador`);

                this.drawtable();
            }

            async put(inputs, selects, id) {

                console.log(inputs);
                console.log(selects);
                console.log(id);

                let headersList = {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }

                let bodyContent = JSON.stringify({
                    "nombreCamper": inputs[0].value,
                    "apellidoCamper": inputs[1].value,
                    "fechaNac": inputs[2].value,
                    "idReg": selects[0].value,
                  },);

                console.log(bodyContent);
                let response = await fetch(`${this.url}${id}`, {
                    method: "PUT",
                    body: bodyContent,
                    headers: headersList
                });

                let res = await response.json();

                console.log(res);

                res.Code == 200 ? alert(`item actualizado con exito`) : alert(`item no puedo ser actualizado`);

                this.drawtable();
            }


            async region(id){

                let headersList = {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }

                let response_areas = await fetch(`http://localhost/ApolT01-009/testphp/region/${id}`, {
                    method: "GET",
                    headers: headersList
                });
                let data = await response_areas.json();
                let plantilla_areas = '';
                data.Message.forEach((item) => {

                    plantilla_areas += `
                        <option value="${item.idReg}">${item.region}</option>
                    `
                });

                this.querySelectorAll('#idReg').forEach((item) => {
                    item.innerHTML = plantilla_areas;
                })
            }

            edit(item) {

                alert('Para cambiar de region debes seleccionar el departameto primero')

                let selects = this.querySelectorAll('select');

                let region = selects[1].cloneNode(true);



                let row = document.elementFromPoint(item.clientX, item.clientY).parentNode.parentNode.parentNode.parentNode
                row.querySelectorAll('td')[0].innerHTML = `<input type="text" value="${row.querySelectorAll('td')[0].textContent}" class="form-control" ></input>`
                row.querySelectorAll('td')[1].innerHTML = `<input type="text" value="${row.querySelectorAll('td')[1].textContent}" class="form-control" ></input>`
                row.querySelectorAll('td')[2].innerHTML = `<input type="date" value="${row.querySelectorAll('td')[2].textContent}" class="form-control" ></input>`



                row.querySelectorAll('td')[3].innerHTML = '';
                row.querySelectorAll('td')[3].appendChild(region);



                item.target.innerHTML = `
                    <button data-status="ok">
                        OK
                        <i class='bx bx-check'></i>
                    </button>
                
                `
                row.querySelectorAll("[data-name='delete']")[0].dataset.name = 'close';
                row.querySelectorAll("[data-name='close']")[0].addEventListener("click", () => {
                    this.drawtable();
                })

                console.log();

                this.querySelector("button[data-status]").addEventListener("click", (e) => {
                    e.target.dataset.status === 'ok' ? this.put(row.querySelectorAll('input'), row.querySelectorAll('select'), item.target.dataset.id) : null;
                    e.target.dataset.name === 'delete' ? this.drawtable() : null;
                })


            }

            async acction() {
                this.querySelector("#data-get").addEventListener("click", (e) => {
                    e.target.dataset.name === 'delete' ? this.delete(e.target.dataset) : null;
                    e.target.dataset.name === 'edit' ? this.edit(e) : null;
                })
            }

            async connectedCallback() {

                //post
                console.log(this.querySelector('#my-form'));
                this.querySelector('#my-form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    let data = Object.fromEntries(new FormData(e.target));
                    console.log(data);

                    let headersList = {
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }


                    let response = await fetch(this.url, {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: headersList
                    });

                    let fetch_data = await response.json();
                    console.log(fetch_data);

                    fetch_data.Code !== 200 ? alert(fetch_data.Message) : this.drawtable();
                    this.drawtable()
                })

                //get

                this.drawtable();

                this.acction();

                this.querySelector('#idDep').addEventListener('input', async (e) => {
                    this.region(e.target.value);
                })


            }
        }
        window.customElements.define(componet[1], this.name);
    }

}
