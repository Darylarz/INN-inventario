<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label>Categoría</label>
        <input type="text" name="categoria" class="input"
               value="{{ old('categoria', $consumible->categoria ?? '') }}">
    </div>

    <div>
        <label>Marca</label>
        <input type="text" name="marca" class="input"
               value="{{ old('marca', $consumible->marca ?? '') }}">
    </div>

    <div>
        <label>Modelo</label>
        <input type="text" name="modelo" class="input"
               value="{{ old('modelo', $consumible->modelo ?? '') }}">
    </div>

    <div>
        <label>Modelo de impresora compatible</label>
        <input type="text" name="modelo_impresora" class="input"
               value="{{ old('modelo_impresora', $consumible->modelo_impresora ?? '') }}">
    </div>

    <div>
        <label>Color (si aplica)</label>
        <input type="text" name="color" class="input"
               value="{{ old('color', $consumible->color ?? '') }}">
    </div>

    <div>
        <label>Tipo de material (si aplica)</label>
        <input type="text" name="tipo_material" class="input"
               value="{{ old('tipo_material', $consumible->tipo_material ?? '') }}">
    </div>

    <div>
        <label>Impresora destino</label>
        <input type="text" name="impresora_destino" class="input"
               value="{{ old('impresora_destino', $consumible->impresora_destino ?? '') }}">
    </div>

</div>
