<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" class="input"
               value="{{ old('nombre', $herramienta->nombre ?? '') }}">
    </div>

    <div>
        <label>Tipo de herramienta</label>
        <input type="text" name="tipo" class="input"
               value="{{ old('tipo', $herramienta->tipo ?? '') }}">
    </div>

</div>