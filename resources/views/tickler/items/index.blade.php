<x-app-layout>

<x-slot name="header">

<div class="flex justify-between">

<h2>{{ $tickler->company }} Items</h2>

<a
href="{{ route('tickler.items.create',$tickler) }}"
class="bg-blue-600 text-white px-4 py-2 rounded">
Add Item
</a>

</div>

</x-slot>

<div class="py-6">

<div class="max-w-7xl mx-auto">

<table class="min-w-full">

<thead>

<tr>

<th>Sort</th>

<th>Item</th>

<th>Name</th>

<th>Approved By</th>

<th></th>

</tr>

</thead>

<tbody>

@foreach($items as $item)

<tr>

<td>{{ $item->sort }}</td>

<td>{{ $item->item }}</td>

<td>{{ $item->name }}</td>

<td>{{ $item->approved_by_name }}</td>

<td>

<a href="{{ route('tickler.items.show',[$tickler,$item]) }}">
View
</a>

<a href="{{ route('tickler.items.edit',[$tickler,$item]) }}">
Edit
</a>

<form
action="{{ route('tickler.items.destroy',[$tickler,$item]) }}"
method="POST"
class="inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('Delete?')"
class="text-red-600">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</x-app-layout>