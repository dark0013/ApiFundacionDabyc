var contenido = document.querySelector('#contenido')

function traer() {
  fetch('http://localhost/apilis/controllers/producto?page=1', {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin':'*',
         
          'Content-Type': 'application/json'
        }
      }

    )
    .then(res => res.json())
    .then(datos => {
      // console.log(datos)
      tabla(datos)
    })
}

function tabla(datos) {
  // console.log(datos)
  contenido.innerHTML = ''
  for (let valor of datos) {
    // console.log(valor.nombre)
    contenido.innerHTML += `
            
            <tr>
                <th scope="row">${ valor.id_catalogo_producto }</th>
                <td>${ valor.ruta }</td>
                <td>${ valor.id_siete_lineas }</td>
            </tr>
            
            `
  }
}