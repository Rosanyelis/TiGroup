<button class="btn btn-sm btn-icon btn-text-secondary
    rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ri-more-2-line ri-20px"></i>
</button>
<div class="dropdown-menu dropdown-menu-end m-0" style="">
        <a class="dropdown-item text-info" href="#"  onclick="viewRecord({{ $data->id }})">
            <i class="ri-eye-line ri-20px"></i>
            Ver Cotizacion
        </a>
        @if ($data->status != 'Facturado' && $data->status != 'Pagado')
        <a class="dropdown-item text-primary" href="{{ route('quote.edit', $data->id) }}">
            <i class="ri-edit-2-line ri-20px"></i>
            Editar Cotizacion
        </a>
        <a class="dropdown-item text-danger" href="#" onclick="deleteRecord({{ $data->id }})" >
            <i class="ri-delete-bin-fill ri-20px"></i>
            Eliminar Cotizacion
        </a>
        @endif
        <a class="dropdown-item text-warning " href="{{ route('quote.quotepdf', $data->id) }}"
            target="_blank">
            <i class="ri-file-pdf-2-line ri-20px"></i> Cotizacion PDF
        </a>
        <a class="dropdown-item text-success" href="{{ route('quote.sendEmailQuotepdf', $data->id) }}">
            <i class="ri-mail-send-line ri-20px"></i>
            Enviar Cotizacion
        </a>
</div>

