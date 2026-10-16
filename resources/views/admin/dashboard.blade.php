@extends('admin.layout')
@section('content')
<div class="dashboard-head"><div><p class="adm-eyebrow">Workspace overview · {{ now()->format('l, d F Y') }}</p><h1>Dashboard</h1><p class="adm-subtitle">A clear view of incoming work and what needs your attention.</p></div><div class="dashboard-actions"><a class="btn sm" href="{{ route('admin.leads', ['status' => 'new']) }}">Review new leads <span class="action-count">{{ $metrics[1]['value'] }}</span></a><a class="dashboard-view-link" href="{{ route('home') }}" target="_blank" rel="noopener">View website ↗</a></div></div>

<section class="dashboard-metrics" aria-label="Lead metrics">
	@foreach ($metrics as $metric)<article class="metric-panel metric-{{ $metric['tone'] }}"><p>{{ $metric['label'] }}</p><strong>{{ $metric['value'] }}</strong><span>{{ $metric['note'] }}</span></article>@endforeach
</section>

<div class="dashboard-grid">
	<section class="dashboard-panel activity-panel">
		<div class="panel-heading"><div><p class="adm-eyebrow">Lead activity</p><h2>Last 7 days</h2></div><span class="panel-total">{{ $weeklyLeads->sum('count') }} total</span></div>
		<div class="activity-chart" role="img" aria-label="Lead activity for the last seven days">
			@foreach ($weeklyLeads as $day)<div class="activity-day" aria-label="{{ $day['date'] }}: {{ $day['count'] }} leads"><span class="activity-value">{{ $day['count'] ?: '' }}</span><div class="activity-track"><span style="height: {{ $day['height'] }}%"></span></div><span class="activity-label">{{ $day['label'] }}</span></div>@endforeach
		</div>
	</section>

	<section class="dashboard-panel pipeline-panel">
		<div class="panel-heading"><div><p class="adm-eyebrow">Lead pipeline</p><h2>By status</h2></div><a href="{{ route('admin.leads') }}">Manage leads →</a></div>
		<div class="pipeline-list">@foreach ($statusCounts as $status => $count)<div class="pipeline-row"><span class="tag {{ $status }}">{{ ucfirst($status) }}</span><strong>{{ $count }}</strong></div>@endforeach</div>
	</section>
</div>

<section class="dashboard-panel latest-panel">
	<div class="panel-heading"><div><p class="adm-eyebrow">Latest enquiries</p><h2>Recent leads</h2></div><a href="{{ route('admin.leads') }}">View all leads →</a></div>
	@if ($latest->isNotEmpty())
		<div class="dashboard-table-wrap"><table class="tbl dashboard-table"><thead><tr><th>Contact</th><th>Project interest</th><th>Received</th><th>Status</th><th></th></tr></thead><tbody>
		@foreach ($latest as $lead)<tr><td><strong>{{ $lead->name }}</strong><small>{{ $lead->email }}@if($lead->company) · {{ $lead->company }}@endif</small></td><td>{{ $lead->package ?: ($lead->service ?: 'General enquiry') }}</td><td>{{ $lead->created_at->format('d M, H:i') }}</td><td><span class="tag {{ $lead->status }}">{{ ucfirst($lead->status) }}</span></td><td><a href="{{ route('admin.leads', ['q' => $lead->email]) }}">Open</a></td></tr>@endforeach
		</tbody></table></div>
	@else
		<div class="dashboard-empty"><span aria-hidden="true">↗</span><h3>No enquiries yet</h3><p>New project requests will appear here.</p><a href="{{ route('contact') }}" target="_blank" rel="noopener">Preview contact form</a></div>
	@endif
</section>

<section class="dashboard-content"><div class="panel-heading"><div><p class="adm-eyebrow">Published content</p><h2>Site content</h2></div><div class="dashboard-settings-links"><a href="{{ route('admin.index', 'pages') }}">Website pages →</a><a href="{{ route('admin.site-settings') }}">Header &amp; footer →</a></div></div><div class="content-shortcuts">@foreach ($contentCounts as $type => $count)<a href="{{ route('admin.index', strtolower($type)) }}"><span>{{ $type }}</span><strong>{{ $count }}</strong><span>Manage {{ strtolower($type) }} →</span></a>@endforeach</div></section>
@endsection
