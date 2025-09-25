<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LOGIN - SYSTEM </title>
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- BOOSTRAP CSS, JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
        <style>
        body {
            background-color: black;
            color: white
        }
        body{
             display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            margin: 300px;

        }

     .card-body {
      display: flex;
      flex-direction: column;
      gap: 1px;
      align-items: center; 

     }  
        .text-font{
    
            
        }
  
 
    </style>

</head>

<body>

    <main>
       <div class="card" style="width: 21.5rem;">
  <div class="card-body">
    <h2 class="card-title mb-1" style="height: 75px; text-align: center"> <i> SISTEMA DE CADASTRO </i></h2>
     <i class="bi bi-file-earmark-plus" style="font-size: 60px;"></i>

        <div class="text-font">
            <i>
            <br> <strong> Rapido, seguro e intuitivo. </strong>
            </i>
        </div>
        <a href="cadastro.php" class="btn border border-info btn btn-primary text-light card-body d-flex flex-column align-items-center" style="width: 200px; padding: 3px; margin-top: 1rem;"> <i class="bi bi-box-arrow-right"> <strong> CADASTRAR </strong></i></a>

        <a href="listagem.php" class="btn border border-info btn btn-primary text-light  card-body d-flex flex-column align-items-center mb-3 " style="width: 200px; padding: 3px; margin-top: 0.6rem; "> <i class="bi bi-person-gear"> <strong> LISTAR </strong> </i></a>
         </div>
             </div>
               </div>
                    </div>

    </main>

</body>
</html>