<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prueba apis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

  <div class="container my-5 text-center">
    <button class="btn btn-danger w-100" onclick="traer()">Obtener</button>
    <div class="mt-5">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">url</th>
            <th scope="col">orden de linea</th>
          </tr>
        </thead>
        <tbody id="contenido">

        </tbody>
      </table>
    </div>
  </div>

  <script src="../js/producto.js"></script>

</body>

</html>