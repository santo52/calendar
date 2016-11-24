<?php include 'partials/header.php' ?>
<body>

<section class="hidden Popup-Container" id="Users">
    <article class="Popup">
        <span class="close Popup-close">X</span>
        <h2 id="Popup-title"> Cargando </h2>
        <section class="Content" id="Popup-form">
            Espere un momento mientras cargan los datos.
        </section>
    </article>
</section>

<section class="hidden Popup-Container" id="Calendar">
    <article class="Popup">
        <span class="close Popup-close">X</span>
        <h2 id="Popup-title"> Insertar calendario </h2>
        <section class="row Content" id="Popup-form">
            <div class="col-xs-6 input-append date form_datetime" data-date="2012-12-21T15:25:00Z">
                <span>Fecha inicial</span>
                <input size="16" type="text" value="" id="calendarStart">
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <div class="col-xs-6 input-append date form_datetime" data-date="2012-12-21T15:25:00Z">
                <span>Fecha Final</span>
                <input size="16" type="text" value="" id="calendarEnd">
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <div style="margin: 10px 0" class="col-xs-12 input-append">
                <span>Escriba el titulo</span>
                <input class="col-xs-12" type="text" id="calendarTitle" placeholder="Escriba el titulo">
            </div>
            <div style="margin: 10px 0" class="col-xs-12 input-append">
                <span>Escriba el Descripción</span>
                <input class="col-xs-12" type="text" id="calendarDescription" placeholder="Escriba la descripción">
            </div>
            <div style="margin: 10px 0" class="col-xs-12 input-append">
                <input class="col-xs-12 btn btn-default" type="submit" data-action="calendarCreate" id="calendarCreate" value="Crear calendario">
            </div>

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
<?php include 'partials/calendar.php'?>
<!--<div style="margin: 20px auto; width: 500px;">
    <iframe src="https://calendar.google.com/calendar/embed?src=unbd5fgdiijq9qtf7iorrvkvos%40group.calendar.google.com&ctz=America/Bogota" style="border: 0" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</div>-->
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
