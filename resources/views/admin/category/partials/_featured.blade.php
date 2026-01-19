<form method="POST" action="{{ route('category.change-featured-status', $data->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  @method('put')
  <button type="submit" class="btn btn-link">
      <i class="{{ $data->is_featured == 'Y' ? 'fal fa-check' : 'fal fa-backspace' }}"></i>
  </button>
</form>
