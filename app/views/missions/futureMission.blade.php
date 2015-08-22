@extends('templates.main')

@section('title', $mission->name)
@section('bodyClass', 'future-mission')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper" ng-app="futureMissionApp" ng-controller="futureMissionController" ng-strict-di>
	<h1>{{ $mission->name }}</h1>
	<main>
		<nav class="sticky-bar">
			<ul class="container">
				<li class="grid-1">Countdown</li>
				<li class="grid-1">Details</li>
				<li class="grid-1">Timeline</li>
                @if (Auth::isSubscriber())
				    <li class="grid-1">Articles</li>
                @endif

				<li class="grid-2 prefix-3 actions">
					@if (Auth::isAdmin())
						<a href="/missions/{{$mission->slug}}/edit"><i class="fa fa-pencil"></i></a>
					@endif
					<i class="fa fa-twitter"></i>
					@if (Auth::isMember())
						<a href="/users/{{Auth::user()->username}}/edit#email-notifications"><i class="fa fa-envelope-o"></i></a>
					@else
						<a href="/docs#email-notifications"><i class="fa fa-envelope-o"></i></a>
					@endif
					<i class="fa fa-calendar"></i>
					<a href="http://www.google.com/calendar/render?cid={{ Request::url() }}"><i class="fa fa-google"></i></a>
					<i class="fa fa-rss"></i>
				</li>
				<li class="grid-1">Status</li>
			</ul>
		</nav>
		<section class="highlights" ng-if="isLaunchExact == true">
            <div class="webcast-status" data-bind="css: webcast.status, visible: webcast.status !== 'webcast-inactive'">
                <span>[[ webcast.publicStatus ]]</span><span class="live-viewers" data-bind="visible: webcast.status() === 'webcast-live'">[[ webcast.publicViewers ]]</span>
            </div>
            <div class="display-date-time">
                <div class="launch" data-bind="text: launchDateTime"></div>
                <div class="timezone">
                    <span class="timezone-current">UTC</span>
                    <ul class="timezone-list">
                        <li class="timezone-option">Local</li>
                        <li class="timezone-option">ET</li>
                        <li class="timezone-option">PT</li>
                        <li class="timezone-option active">UTC</li>
                    </ul>
                </div>
            </div>
		</section>
		<section class="hero" id="countdown">
            <countdown specificity="launchSpecificity" countdown-to="launchDateTime" callback="requestFrequencyMananger"></countdown>
		</section>
		<p>{{ $mission->summary }}</p>
		<h2>Details</h2>
        <section class="details">
            <div id="live-tweets">

            </div>
        </section>
		<h2>Timeline</h2>
        <section class="timeline">
            <canvas></canvas>
        </section>
        @if (Auth::isSubscriber())
            <h2>Articles</h2>
            <section class="articles">

            </section>
        @endif
	</main>
</div>
@stop