<form method="POST" action="{{ route('delete-user', $row->id) }}" class="d-inline"
  onsubmit="return submitDeleteForm(this)">
@csrf
@method('delete')
@if ($row->id != 1)
<button type="submit"
      class="relative flex justify-between w-full cursor-pointer select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
      <i class="fal fa-trash text-red"></i>
</button>
@endif
</form>

