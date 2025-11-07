// ...
use App\Models\Inventory; // <--- RENOMBRADO
use Illuminate\Validation\Rule;

class InventoryManagementController extends Controller
{
    // ... create() method, solo renombrar Article a Inventory ...

    public function store(Request $request): RedirectResponse
    {
        // Verificar permiso
        if (!auth()->user()->can('articulo agregar')) { 
            // NOTA: MANTENEMOS EL PERMISO GENÉRICO 'articulo agregar'
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para agregar inventario.');
        }
        
        // VALIDACIÓN DINÁMICA BASADA EN EL CAMPO 'type' ENVIADO POR EL FORMULARIO
        $request->validate(['type' => 'required|in:activo,herramienta,consumible_toner,consumible_material']);
        $type = $request->input('type');

        $baseRules = [
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255', Rule::unique('inventories', 'serial_number')],
            'national_asset_tag' => ['nullable', 'string', 'max:255', Rule::unique('inventories', 'national_asset_tag')],
        ];
        
        if ($type === 'activo') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'item_type' => 'required|string',
                'capacity' => 'nullable|string',
                'generation' => 'nullable|string',
                'watt_capacity' => 'nullable|numeric|min:0',
            ]);
        } elseif ($type === 'herramienta') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre de la herramienta
            ]);
        } elseif ($type === 'consumible_toner') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'printer_model' => 'required|string',
                'toner_color' => 'required|string',
            ]);
        } elseif ($type === 'consumible_material') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre del material
                'material_type' => 'required|string', // Tipo de material (ej: papel, tinta)
            ]);
        } else {
            // Manejar caso no válido (aunque la validación 'in' debería prevenir esto)
            return redirect()->back()->withInput()->withErrors(['type' => 'Tipo de inventario no válido.']);
        }
        
        $validatedData = $request->validate($rules);
        $validatedData['type'] = $type; // Asegurar que el campo type se guarde

        Inventory::create($validatedData); // <--- RENOMBRADO

        return redirect()->route('dashboard')->with('status', 'Ítem de inventario creado exitosamente.');
    }
}