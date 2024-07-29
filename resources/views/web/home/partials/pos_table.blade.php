			<table id="pos-list" class="table table-hover">
				<thead>
					<th>Miejscowość</th>
					<th>Adres punktu</th>
				</thead>
				<tbody>
				@foreach($pos as $p)
					<tr data-lat="{{ $p->lat }}" data-lng="{{ $p->lng }}" class="pointer">
						<td>{{ $p->city }}</td>
						<td>{{ $p->name }}<br />{{ $p->street }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>