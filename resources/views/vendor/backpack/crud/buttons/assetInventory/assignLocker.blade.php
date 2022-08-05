<button  data-toggle="modal" data-target="#quantityModal{{ $entry->id }}"  class="btn btn-xs btn-default" id="lookup" data-style="zoom-in" title="Assign to Student">
	<i class="fa fa-plus"></i>
</button>

{{-- href="item-inventory/favorite/{{ $entry->id }}" --}}


<div id="quantityModal{{ $entry->id }}" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<form method="post" action="{{ url('admin/locker/' . $entry->id . '/assign') }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Assign <b>{{ $entry->name }}</b></h4>
				</div>
				<div class="modal-body">
						{!! csrf_field() !!}
						<div class="row">
							
							<div class="form-group col-md-12">
								<label for="studentnumber">Student Number</label><br>
								<input style="width: 100%;" type="number" min="1" id="studentnumber" class="form-control" name="studentnumber" required>
							</div>
							<br><br>
							<div class="form-group col-md-12">
								<label for="description">Description</label><br>
								<textarea style="width: 100%;" name="description" id="description" class="form-control" placeholder="optional"></textarea>
							</div>

						</div>
					
					{{-- {{ $entry->id }} --}}
				</div>
				<div class="clearfix"></div>
				<div class="modal-footer">
					<button class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>

	</div>
</div>