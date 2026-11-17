@extends('layouts.master_admin')

@section('controll')
Gửi khuyến mãi
@endsection

@section('content')
<section class="content">
	@if (session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	@if ($errors->any())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif

	<form method="POST" action="/admin/promotion/send">
		@csrf
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Nội dung</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="subject">Tiêu đề</label>
							<input type="text" class="form-control" id="subject" name="subject" maxlength="150" value="{{ old('subject') }}" required>
						</div>
						<div class="form-group">
							<label for="content">Nội dung (email và SMS)</label>
							<textarea class="form-control" id="content" name="content" rows="5" maxlength="2000" required>{{ old('content') }}</textarea>
							<p class="help-block">SMS được ghép thành "Tiêu đề: Nội dung". Nên giữ ngắn để không bị tách thành nhiều tin.</p>
						</div>
						<div class="form-group">
							<label>Kênh gửi</label><br>
							<label class="checkbox-inline"><input type="checkbox" name="channels[]" value="email" checked> Email</label>
							<label class="checkbox-inline"><input type="checkbox" name="channels[]" value="sms"> SMS</label>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" name="test" value="1" class="btn btn-default">Gửi email thử cho tôi</button>
						<button type="submit" class="btn btn-success" onclick="return confirm('Gửi khuyến mãi tới các khách đã chọn?');">Gửi tới khách đã chọn</button>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Chọn khách hàng</h3>
						<div class="pull-right">
							<button type="button" class="btn btn-xs btn-default" onclick="toggleAll(true)">Chọn tất cả</button>
							<button type="button" class="btn btn-xs btn-default" onclick="toggleAll(false)">Bỏ chọn</button>
						</div>
					</div>
					<div class="box-body table-responsive" style="max-height: 480px; overflow-y: auto;">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width:40px;"></th>
									<th>Tên</th>
									<th>Email</th>
									<th>SĐT</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($customers as $customer)
								<tr>
									<td><input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}" class="cust-check"></td>
									<td>{{ $customer->name }}</td>
									<td>{{ $customer->email ?: '—' }}</td>
									<td>{{ $customer->phone_number }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>

<script>
function toggleAll(state) {
	document.querySelectorAll('.cust-check').forEach(function (el) { el.checked = state; });
}
</script>
@endsection
