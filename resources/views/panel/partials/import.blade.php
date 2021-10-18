<form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data" class="ml-2">
    @csrf
    <input type="file" name="import_file" required/>
    <button class="btn btn-primary">{{ __('general.import') }} (.xlsx)</button>
</form>
