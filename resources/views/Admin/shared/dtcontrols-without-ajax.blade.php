@if (isset($editUrl))
    <a href="{{ $editUrl }}" class="btn btn-warning btn-sm" style="height:31px;position:relative;top:5px">
        <i class="fa fa-edit" style="font-size:20px;color:white"></i>
    </a>
@endif

@if (isset($deleteUrl))
    <button type="submit" class="btn btn-danger btn-sm" onClick="destroy('{{ $deleteUrl }}')" style="margin:5px;">
        <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
    </button>
@endif
@if (isset($cancelUrl))
    <button type="submit" class="btn btn-warning btn-sm" onClick="cansel('{{ $cancelUrl }}')"> Cancel</button>
@endif
