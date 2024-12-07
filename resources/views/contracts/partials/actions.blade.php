<button class="btn btn-sm btn-icon btn-text-secondary
    rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ri-more-2-line ri-20px"></i>
</button>
<div class="dropdown-menu dropdown-menu-end m-0" style="">
        <a class="dropdown-item text-info" href="#"  onclick="viewRecord({{ $data->id }})">
            <i class="ri-eye-line ri-20px"></i>
            Ver Contrato
        </a>

        <a class="dropdown-item text-primary" href="{{ route('contract.edit', $data->id) }}" >
            <i class="ri-edit-2-line ri-20px"></i>
            Editar Contrato
        </a>

        <a class="dropdown-item text-danger" href="#" onclick="deleteRecord({{ $data->id }})" >
            <i class="ri-delete-bin-fill ri-20px"></i>
            Eliminar Contrato
        </a>
        @if ($data->end_date <= date('Y-m-d') && $data->status == 'Activo' || $data->status == 'Vencido')
        <a class="dropdown-item text-primary " href="{{ route('contract.renew_contract', $data->id) }}">
            <i class="ri-arrow-up-down-line ri-20px"></i> Renovar Contrato
        </a>
        @endif
</div>
