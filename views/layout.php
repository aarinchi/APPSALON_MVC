<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
    <script type="text/javascript">(function () { var ldk = document.createElement('script'); ldk.type = 'text/javascript'; ldk.async = true; ldk.src = 'https://s.cliengo.com/weboptimizer/648ea2d16aa6f900320d2188/648eab2353835d00324429ad.js?platform=onboarding_modular'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ldk, s); })();</script>
</head>

<body>
    
    <div class="contenedor-app">

        <div class="imagen"></div>

        <div class="app">
            <?php echo $contenido; ?>
        </div>
        
    </div>

    <?php
        echo $script ?? ''; //Lo dejamos en vacio para no tener errores que la variable no existe en otros documentos por ejm: la pagina principal
    ?>
    
            
</body>

</html>