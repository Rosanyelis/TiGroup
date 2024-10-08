<button type="button" class="btn btn-sm btn-icon btn-text-info
    rounded-pill" onclick="viewRecord({{ $id }})"
    data-bs-toggle="tooltip" title="Ver Proveedor">
    <i class="ri-eye-line ri-20px"></i>
</button>
<a href="{{ route('supplier.edit', $id) }}" class="btn btn-sm btn-icon btn-text-secondary
    rounded-pill"
    data-bs-toggle="tooltip" title="Editar Proveedor">
    <i class="ri-edit-2-line ri-20px"></i>
</a>
<a href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary
    rounded-pill text-danger"
    data-bs-toggle="tooltip" title="Eliminar Proveedor"
    onclick="deleteRecord({{ $id }})">
    <i class="ri-delete-bin-7-line ri-20px"></i>
</a>
