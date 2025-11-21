<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label>Marca</label>
        <input type="text" name="marca" class="input"
               value="{{ old('marca', $articulo->marca ?? '') }}">
    </div>

    <div>
        <label>Modelo</label>
        <input type="text" name="modelo" class="input"
               value="{{ old('modelo', $articulo->modelo ?? '') }}">
    </div>

    <div>
        <label>Capacidad (si aplica)</label>
        <input type="text" name="capacidad" class="input"
               value="{{ old('capacidad', $articulo->capacidad ?? '') }}">
    </div>

    <div>
        <label>Tipo</label>
        <input type="text" name="tipo" class="input"
               value="{{ old('tipo', $articulo->tipo ?? '') }}">
    </div>

    <div>
        <label>Generación</label>
        <input type="text" name="generacion" class="input"
               value="{{ old('generacion', $articulo->generacion ?? '') }}">
    </div>

    <div>
        <label>Capacidad Watt (si aplica)</label>
        <input type="number" name="capacidad_watt" class="input"
               value="{{ old('capacidad_watt', $articulo->capacidad_watt ?? '') }}">
    </div>

    <div>
        <label>Serial</label>
        <input type="text" name="serial" class="input"
               value="{{ old('serial', $articulo->serial ?? '') }}">
    </div>

    <div>
        <label>Bien Nacional</label>
        <input type="text" name="bien_nacional" class="input"
               value="{{ old('bien_nacional', $articulo->bien_nacional ?? '') }}">
    </div>

</div>
