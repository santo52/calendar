<?php include 'partials/header.php' ?>
<body>
<?php Y-m-d\TH:i:sP ?>
    <section class="hidden Popup-Container">
        <article class="Popup">
            <span class="close Popup-close">X</span>
            <h2 id="Popup-title"> Cargando </h2>
            <section class="Content" id="Popup-form">
                Espere un momento mientras cargan los datos.
            </section>
        </article>
    </section>

    <div class="linkButton" style="position: relative;">
        <a href="#" class="Popup-open" data-title="Crear contacto" data-action="create" >Nuevo contacto</a>
    </div>
    <table class="table table-hover" align=center >
        <thead>
        <tr>
            <th><a href="?orderby=name">Nombre</a></th>
            <th><a href="?orderby=phone">Telefono</a></th>
            <th><a href="?orderby=email">Email</a></th>
            <th><a href="?orderby=address">Direccion</a></th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo htmlentities($contact->name); ?></td>
                <td><?php echo htmlentities($contact->phone); ?></td>
                <td><?php echo htmlentities($contact->email); ?></td>
                <td><?php echo htmlentities($contact->address); ?></td>
                <td>
                    <a href="#" class="Popup-open" data-title="Actualizar contacto" data-action="edit" data-id="<?php echo $contact->id; ?>">Actualizar</a>
                    <a href="index.php?handle=delete&id=<?php echo $contact->id; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php include 'partials/scripts.php' ?>
    <script>
        setInputs([
            {name : 'name', text : 'Nombre'},
            {name : 'phone', text : 'Teléfono'},
            {name : 'email', text : 'E-mail'},
            {name : 'address', text : 'Dirección'}
        ])
    </script>
    </body>
</html>
