<button class="btn btn-sm btn-icon btn-text-secondary
    rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ri-more-2-line ri-20px"></i>
</button>
<div class="dropdown-menu dropdown-menu-end m-0" style="">
        <a class="dropdown-item text-info" href="#"  onclick="viewRecord({{ $data->id }})">
            <i class="ri-eye-line ri-20px"></i>
            Ver Orden de Trabajo
        </a>
        <a class="dropdown-item text-primary" href="{{ route('workorder.edit', $data->id) }}" >
            <i class="ri-edit-2-line ri-20px"></i>
            Editar Orden de Trabajo
        </a>
</div>

